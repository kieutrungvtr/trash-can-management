<?php


namespace App\Http\Controllers;


use App\Models\Sql\Trash;
use App\Models\Sql\TrashGroup;
use App\Models\Sql\TrashInfo;
use App\Models\Sql\TrashLocation;
use App\Models\Sql\TrashType;
use App\Models\Sql\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class QRController extends Controller
{

    public function index(Request $request)
    {
        Session::start();
        $user_id = Session::get('user_id', 0);
        $user = null;
        if ($user_id) {
            $user = User::query()->find($user_id);
        }
        $code = $request->get("code", '');
        $trash = Trash::query()->where('trash_qr', $code)->get()->first();
        $trash_type_list = TrashType::getCacheList();
        $trash_location_list = TrashLocation::getCacheList();
        $trash_group_list = TrashGroup::getCacheList2();
        return view("qr_scan", [
            "trash" => $trash,
            'trash_type_list' => $trash_type_list,
            'user' => $user,
            'trash_location_list' => $trash_location_list,
            'trash_group_list' => $trash_group_list,
        ]);
    }

    public function input(Request $request) {
        $qr_code = $request->get("qr_code", '');
        $user_name = $request->get("user_name", '');
        $user_phone = $request->get("user_phone", '');
        $user_gender = $request->get("user_gender", 0);
        $trash_info_weight = $request->get("trash_info_weight", '');

        Session::start();
        $trash = Trash::query()->where('trash_qr', $qr_code)->get()->first();
        if (!$trash) {
            throw ValidationException::withMessages([
                'error' => "QRCode không tồn tại"
            ]);
        }
        $user_query = User::query()->where('user_name', trim($user_name));
        if ($user_phone) {
            $user_query->where('user_phone', trim($user_phone));
        } else {
            $user_query->whereNull('user_phone');
        }
        $user = $user_query->first();
        if (!$user) {
            $user = new User();
        }
        $user->user_name = $user_name;
        if ($user_phone) {
            $user->user_phone = $user_phone;
        }
        $user->user_gender = $user_gender;
        $user->save();

        Session::put('user_id', $user->user_id);

        $trash_info = new TrashInfo();
        $trash_info->user_index = $user->user_id;
        $trash_info->trash_index = $trash->trash_id;
        $trash_info->trash_type_index = $trash->trash_type_index;
        $trash_info->trash_group_index = $trash->trash_group_index;
        $trash_info->trash_location_index = $trash->trash_location_index;
        $trash_info->trash_info_weight = $trash_info_weight;
        $trash_info->save();
        return Redirect::back()->with('success', 1)
            ->withCookie(cookie('user_name', $user->user_name, 0, null, null, null, false))
            ->withCookie(cookie('user_phone', $user->user_phone, 0, null, null, null, false))
            ->withCookie(cookie('user_gender', $user->user_gender, 0, null, null, null, false))
            ;
    }
}
