<?php

namespace App\Exports;

use App\Models\Sql\TrashGroup;
use App\Models\Sql\TrashInfo;
use App\Models\Sql\TrashLocation;
use App\Models\Sql\TrashType;
use App\Models\Sql\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class DataExport implements FromCollection
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
        $trash_group_list = TrashGroup::getCacheList2();
        $trash_location_list = TrashLocation::getCacheList();

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
                $trash_location_list[$trash_location_id]["trash_location_name"],
                $trash_group_list[$trash_group_id]["trash_group_name"],
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
            "Vị trí",
            "Cụm",
            "Loại rác thải",
            "Cân nặng (kg)",
            "Ngày tạo",
        ];
    }
}
