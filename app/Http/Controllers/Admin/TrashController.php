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
        return Redirect::to("/admin");
    }
}
