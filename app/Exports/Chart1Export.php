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
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class Chart1Export implements FromCollection, WithStrictNullComparison
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
        $group_id = $request->get("group", 0);
        $trash_type_list = TrashType::getCacheList();
        $trash_group_list = TrashGroup::getCacheList2();
        $report = TrashInfo::reportByType($group_id, $from, $to);

        $labels = array();
        $data = array();
        $result = [];
        foreach ($trash_type_list as $trash_type_id => $trash_type) {
            $labels[] = $trash_type["trash_type_name"];
            $data[] = $report[$trash_type["trash_type_id"]] ?? 0;
        }
        if ($group_id) {
            $group_name = $trash_group_list[$group_id]["trash_group_name"] ?? '';
            $result[] = array($group_name);
        } else {
            $result[] = array('Tất cả các cụm');
        }
        $result[] = array('Từ ngày', $from);
        $result[] = array('Đến ngày', $to);
        $result[] = $labels;
        $result[] = $data;
        return new Collection($result);
    }
}
