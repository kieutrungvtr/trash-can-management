<?php


namespace App\Http\Controllers\Admin;


use App\Exports\DataExport;
use App\Http\Controllers\Controller;
use App\Models\Sql\TrashGroup;
use App\Models\Sql\TrashInfo;
use App\Models\Sql\TrashLocation;
use App\Models\Sql\TrashType;
use App\Models\Sql\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use function Composer\Autoload\includeFile;

class DataController extends Controller
{
    public function export(Request $request)
    {
        $from = $request->get("from", '');
        $to = $request->get("to", '');
        return Excel::download(new DataExport($from, $to), "data.".date('Ymd_His').'.xlsx');
    }
    public function list(Request $request)
    {
        $from = $request->get("from", date('Y-m-01'));
        $to = $request->get("to", date('Y-m-d'));
        $location_id = $request->get("location_id",'');
        $group_id = $request->get("group_id",'');
        $type = $request->get("type",'');
        $page = $request->get("page",1);
        $limit = $request->get("l",20);

        $trash_type_list = TrashType::getCacheList();
        $trash_location_list = TrashLocation::getCacheList();
        $trash_group_list = TrashGroup::getCacheList();
        $trash_group_list_map = TrashGroup::getCacheList2();
        $user_list = [];
        $result = [];
        $max = TrashInfo::getExportQuery($from, $to, $location_id, $group_id, $type)->count('trash_info_id');
        $data = TrashInfo::getExport($from, $to, $location_id, $group_id, $type, $page, $limit);
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
        $heading = [
            "Tên người dùng",
            "Số điện thoại",
            "Giới tính",
            "Vị trí",
            "Cụm",
            "Loại rác thải",
            "Cân nặng (kg)",
            "Ngày tạo",
        ];
        $new_request = $request;
        $new_request->request->remove('page');
        return view('admin.data.list', array(
            'trash_type_list' => $trash_type_list,
            'trash_location_list' => $trash_location_list,
            'trash_group_list' => $trash_group_list,
            'trash_group_list_map' => $trash_group_list_map,
            'max_type_user' => TrashInfo::maxUserType($trash_type_list),
            'max_group_user' => TrashInfo::maxUserGroup(TrashGroup::getCacheList2()),
            'from' => $from,
            'to' => $to,
            'location_id' => $location_id,
            'group_id' => $group_id,
            'type' => $type,
            'page' => $page,
            'heading' => $heading,
            'listing' => $result,
            'max_page' => floor($max/$limit),
            'page_uri' => $new_request->getUri(),
            'page_parameter' => http_build_query($new_request->toArray()),
        ));
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
