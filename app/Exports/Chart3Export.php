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

class Chart3Export implements FromCollection, WithEvents, WithStrictNullComparison
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

        $result[] = array('Từ ngày', $from);
        $result[] = array('Đến ngày', $to);

        $trash_group_list = TrashGroup::getCacheList();
        $trash_location_list = TrashLocation::getCacheList();
        $report = TrashInfo::reportByWeek($from, $to);

        $week_list = array_unique(array_column($report, 'year_week'));
        $min_week = $max_week = 1;
        if ($week_list) {
            $min_week = min($week_list);
            $max_week = max($week_list);
        }
        $week_diff = TrashInfo::week_diff($min_week, $max_week);

        $data_mapper = array();
        foreach ($report as $report_data) {
            $year_week = $report_data["year_week"];
            $trash_group_id = $report_data["trash_group_index"];
            $data_mapper[$trash_group_id][$year_week] = $report_data['total'];
        }

        $row1 = array("");
        $row2 = array("");
        foreach ($trash_group_list as $trash_location_id => $trash_group_data) {
            $row1[] = $trash_location_list[$trash_location_id]['trash_location_name'];
            for ($i = 1; $i < count($trash_group_data); $i++) {
                $row1[] = '';
            }
            foreach ($trash_group_data as $trash_group) {
                $row2[] = $trash_group["trash_group_name"];
            }
        }
        $result[] = $row1;
        $result[] = $row2;
        for ($week = 1; $week <= $week_diff; $week++) {
            $year_week = TrashInfo::week_plus($min_week, $week-1);
            $row = array("Tuần {$week}");
            foreach ($trash_group_list as $trash_location_id => $trash_group_data) {
                foreach ($trash_group_data as $trash_group_id => $trash_group) {
                    $row[] = $data_mapper[$trash_group_id][$year_week] ?? 0;
                }
            }
            $result[] = $row;
        }
        return new Collection($result);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->mergeCells('A3:A4');
                $trash_group_list = TrashGroup::getCacheList();
                $from = 'B';
                foreach ($trash_group_list as $trash_location_id => $trash_group_data) {
                    $to = $this->increaseColString($from, count($trash_group_data)-1);
                    $event->sheet->getDelegate()->mergeCells("{$from}3:{$to}3");
                    $from = $this->increaseColString($to, 1);
                }
            },
        ];
    }

    public function increaseColString($col, $num)
    {
        do {
            $col++;
        } while (--$num > 0);
        return $col;
    }
}
