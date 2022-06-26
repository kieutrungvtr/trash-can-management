<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Sql\Trash;
use App\Models\Sql\TrashLocation;
use App\Models\Sql\TrashGroup;
use App\Models\Sql\TrashType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TrashController extends Controller
{

    public function createQR(Request $request)
    {
        $qrCode = "";
        if (session('QR')) {
            $qrCode = url("/qr_scan?code=".session('QR'));
        }
        return view("admin.trash.create_qr", array(
            'trashType' => TrashType::getCacheList(),
            'trashGroup' => TrashGroup::getCacheList(),
            'trashLocation' => TrashLocation::getCacheList(),
            'qrCode' => $qrCode
        ));
    }
    public function createQRSubmit(Request $request)
    {
        $request->validate([
            'trash_name' => 'required|string',
        ]);
        $trash_name = $request->post('trash_name');
        $trash_type_index = $request->post('trash_type_index');
        $trash_location_index = $request->post('trash_location_index');
        $trash_group_index = $request->post('trash_group_index');

        $trash = new Trash();
        $trash->trash_name = $trash_name;
        $trash->trash_qr = md5($trash_name) ."_". uniqid();
        $trash->trash_type_index = $trash_type_index;
        $trash->trash_location_index = $trash_location_index;
        $trash->trash_group_index = $trash_group_index;
        $trash->save();

        return Redirect::back()->with('QR', $trash->trash_qr);
    }


    public function list(Request $request)
    {
        $location_id = $request->get("location", '');
        $type_id = $request->get("type", '');
        $group_id = $request->get("group", '');

        $query = Trash::query();
        if ($location_id) {
            $query->where('trash_location_index', $location_id);
        }
        if ($type_id) {
            $query->where('trash_type_index', $type_id);
        }
        if ($group_id) {
            $query->where('trash_group_index', $group_id);
        }
        $trash_list = $query->get()->toArray();
        $trash_location_list = TrashLocation::getCacheList();
        $trash_type_list = TrashType::getCacheList();
        $trash_group_list = TrashGroup::getCacheList2();

        return view("admin.trash.list", array(
            'trash_list' => $trash_list,
            'trash_location_list' => $trash_location_list,
            'trash_type_list' => $trash_type_list,
            'trash_group_list' => $trash_group_list,
            'location' => $location_id,
            'type' => $type_id,
            'group' => $group_id,
        ));
    }
    public function detail(Request $request)
    {
        $trash = Trash::find($request->get("id", 0));
        $trash_location = $trash_type = $trash_group = array();
        if ($trash) {
            $trash_location = TrashLocation::getCacheList()[$trash['trash_location_index']] ?? array();
            $trash_type = TrashType::getCacheList()[$trash['trash_type_index']] ?? array();
            $trash_group = TrashGroup::getCacheList2()[$trash['trash_group_index']] ?? array();
        }

        return view("admin.trash.detail", array(
            'trash' => $trash,
            'trash_location' => $trash_location,
            'trash_type' => $trash_type,
            'trash_group' => $trash_group,
        ));
    }
}
