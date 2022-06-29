<?php

namespace App\Exports;

use App\Models\Sql\TrashGroup;
use App\Models\Sql\TrashInfo;
use App\Models\Sql\TrashLocation;
use App\Models\Sql\TrashType;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class DashboardExport implements FromCollection, WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        $trash_type_list = TrashType::getCacheList();
        $trash_location_list = TrashLocation::getCacheList();
        $trash_group_list = TrashGroup::getCacheList();
        $date_totals = TrashInfo::trashDate();
        $date_totals_list = array_keys($date_totals);
        if ($date_totals_list) {
            $min_date = min($date_totals_list);
            $max_date = max($date_totals_list);
            for ($c_date = $min_date; $c_date <= $max_date; $c_date = date("Y-m-d", strtotime($c_date.' +1 day'))) {
                $date_totals[$c_date] = $date_totals[$c_date] ?? array();
            }
            $date_totals_list = array_keys($date_totals);
            sort($date_totals_list);
        }
        $max_trash_type_info = TrashInfo::maxTrashType();
        $avg_day_type_report = TrashInfo::reportTypeDate();
        $avg_week_type_report = TrashInfo::reportTypeWeek();
        $max_type_user = TrashInfo::maxUserType($trash_type_list);
        $max_group_user = TrashInfo::maxUserGroup(TrashGroup::getCacheList2());
        $max_trash_type_id = $max_trash_type_info["trash_type_index"];
        $max_trash_type_kg = $max_trash_type_info["total"];

        $result[] = array(
            "Loại Rác Có Khối Lượng Lớn Nhất",
            "Khối lượng"
        );
        $result[] = array(
            $trash_type_list[$max_trash_type_id]['trash_type_name']??'Chưa xác định',
            $max_trash_type_kg
        );
        $result[] = array('');
        $result[] = array('');
        $result[] = array("Tổng khối lượng từng loại rác trong ngày");

        $row = array('Ngày');
        foreach ($trash_type_list as $trash_type) {
            $row[] = $trash_type["trash_type_name"];
        }
        $result[] = $row;
        foreach ($date_totals_list as $date) {
            $row = array($date);
            foreach ($trash_type_list as $trash_type) {
                $row[] = $date_totals[$date][$trash_type["trash_type_id"]] ?? 0;
            }
            $result[] = $row;
        }

        $result[] = array('');
        $result[] = array('');
        $result[] = array('Số rác thải trung bình một ngày');
        $row_title = array();
        $row_result = array();
        foreach ($trash_type_list as $trash_type) {
            $row_title[] = $trash_type["trash_type_name"];
            $row_result[] = $avg_day_type_report[$trash_type["trash_type_id"]] ?? 0;
        }
        $result[] = $row_title;
        $result[] = $row_result;

        $result[] = array('');
        $result[] = array('');
        $result[] = array('Số rác thải trung bình một tuần');
        $row_title = array();
        $row_result = array();
        foreach ($trash_type_list as $trash_type) {
            $row_title[] = $trash_type["trash_type_name"];
            $row_result[] = $avg_week_type_report[$trash_type["trash_type_id"]] ?? 0;
        }
        $result[] = $row_title;
        $result[] = $row_result;

        $result[] = array('');
        $result[] = array('');
        $result[] = array('Người đổ rác nhiều nhất theo loại rác');
        $result[] = array('Loại rác', 'Tên người đổi rác', 'Số lượng');
        foreach ($trash_type_list as $trash_type) {
            $max_user = $max_type_user[$trash_type["trash_type_id"]];
            $result[] = array($trash_type['trash_type_name'], $max_user["user_name"] ?? 'Chưa có ai', $max_user['total'] ??0);
        }
        $result[] = array('');
        $result[] = array('');
        $result[] = array('Người đổ rác nhiều nhất theo cụm');
        $result[] = array('Vị trí', 'Cụm', 'Tên người đổi rác', 'Số lượng');
        foreach ($trash_group_list as $trash_location_id => $trash_group_data) {
            foreach ($trash_group_data as $trash_group) {
                $max_user = $max_group_user[$trash_group["trash_group_id"]];
                $result[] = array($trash_location_list[$trash_group['trash_location_index']]['trash_location_name'], $trash_group['trash_group_name'], $max_user["user_name"] ?? 'Chưa có ai', $max_user['total'] ??0);
            }
        }
        return new Collection($result);
    }
}
