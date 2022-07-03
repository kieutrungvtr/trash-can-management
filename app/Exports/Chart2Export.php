<?php

namespace App\Exports;

use App\Models\Sql\TrashGroup;
use App\Models\Sql\TrashInfo;
use App\Models\Sql\TrashLocation;
use App\Models\Sql\TrashType;
use App\Models\Sql\User;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Events\AfterSheet;

class Chart2Export implements FromCollection, WithEvents, WithStrictNullComparison
{
    /**
     * @var Request
     */
    private $_request;

    public function __construct(Request $request)
    {
        $this->_request = $request;
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        $request = $this->_request;

        $from = $request->get("from", date('Y-m-d', time() - 86400*29));
        $to = $request->get("to", date('Y-m-d'));

        $trash_type_list = TrashType::getCacheList();
        $trash_group_list = TrashGroup::getCacheList();
        $trash_location_list = TrashLocation::getCacheList();

        $result[] = array('Từ ngày', $from);
        $result[] = array('Đến ngày', $to);

        $labels = array("", "");
        foreach ($trash_type_list as $trash_type_id => $trash_type) {
            $labels[] = $trash_type['trash_type_name'];
        }
        $result[] = $labels;

        $check_location = [];
        foreach ($trash_group_list as $trash_location_id => $trash_group_data) {
            foreach ($trash_group_data as $trash_group_id => $trash_group) {
                $row = [];
                if ($check_location[$trash_location_id]??0) {
                    $row[] = '';
                } else {
                    $row[] = $trash_location_list[$trash_location_id]['trash_location_name'];
                    $check_location[$trash_location_id] = 1;
                }
                $row[] = $trash_group["trash_group_name"];
                $report = TrashInfo::reportByType($trash_group_id, $from, $to);
                foreach ($trash_type_list as $trash_type_id => $trash_type) {
                    $row[] = $report[$trash_type_id] ?? 0;
                }
                $result[] = $row;
            }
        }
        return new Collection($result);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->mergeCells('A3:B3');
                $from = 4;
                $trash_group_list = TrashGroup::getCacheList();
                foreach ($trash_group_list as $trash_group_data) {
                    $to = $from + count($trash_group_data) -1;
                    $event->sheet->getDelegate()->mergeCells("A{$from}:A{$to}");
                    $event->sheet->getDelegate()->getCell("A{$from}");
                    $event->getDelegate()->getStyle("A{$from}:A{$to}")->getAlignment()->setVertical('top');
                    ;
                    $from = $to+1;
                }
            },
        ];
    }
}
