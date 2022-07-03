<?php

namespace App\Exports;

use App\Models\Sql\TrashGroup;
use App\Models\Sql\TrashInfo;
use App\Models\Sql\TrashLocation;
use App\Models\Sql\TrashType;
use App\Models\Sql\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class DataExport implements FromCollection, WithStrictNullComparison
{
    private $_from;
    private $_to;

    public function __construct($from = null, $to = null)
    {
        $this->_from = $from;
        $this->_to = $to;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $trash_type_list = TrashType::getCacheList();
        $trash_group_list = TrashGroup::getCacheList();
        $trash_group_list_map = TrashGroup::getCacheList2();
        $trash_location_list = TrashLocation::getCacheList();

        $max_type_user = TrashInfo::maxUserType($trash_type_list);
        $max_group_user = TrashInfo::maxUserGroup(TrashGroup::getCacheList2());
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

        $result[] = array('');
        $result[] = array('');
        $user_list = [];
        $result[] = $this->headings();
        $data = TrashInfo::getExport($this->_from, $this->_to);
        foreach ($data as $item) {
            $user_id = $item["user_index"];
            $trash_location_id = $item["trash_location_index"];
            $trash_group_id = $item["trash_group_index"];
            $trash_type_id = $item["trash_type_index"];
            if (!isset($user_list[$user_id])) {
                $user_list[$user_id] = User::query()->find($user_id);
            }
            $result[] = array(
                $user_list[$user_id]["user_name"],
                $user_list[$user_id]["user_phone"],
                $this->gender($user_list[$user_id]["user_gender"]),
                $trash_location_list[$trash_location_id]["trash_location_name"],
                $trash_group_list_map[$trash_group_id]["trash_group_name"],
                $trash_type_list[$trash_type_id]["trash_type_name"],
                $item["trash_info_weight"],
                $item["trash_info_created_at"],
            );
        }
        return new Collection($result);
    }

    /**
     * @return array|string[]
     */
    public function headings(): array
    {
        return [
            "Tên người dùng",
            "Số điện thoại",
            "Giới tính",
            "Vị trí",
            "Cụm",
            "Loại rác thải",
            "Cân nặng (kg)",
            "Ngày tạo",
        ];
    }



    private function gender($id)
    {
        $data = array(
            0 => "Không",
            1 => "Nam",
            2 => "Nữ",
        );
        return $data[$id];
    }
}
