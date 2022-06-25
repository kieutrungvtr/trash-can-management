<?php


namespace App\Http\Controllers;


use App\Models\Sql\Trash;
use App\Models\Sql\TrashInfo;
use App\Models\Sql\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class QRController extends Controller
{

    public function index(Request $request)
    {
        $code = $request->get("code", '');
        $trash = Trash::query()->where('trash_qr', $code)->get()->first();
        return view("qr_scan", ["trash" => $trash]);
    }

    public function input(Request $request) {
        $qr_code = $request->get("qr_code", '');
        $user_name = $request->get("user_name", '');
        $trash_info_weight = $request->get("trash_info_weight", '');

        $trash = Trash::query()->where('trash_qr', $qr_code)->get()->first();
        if (!$trash) {
            throw ValidationException::withMessages([
                'error' => "QRCode không tồn tại"
            ]);
        }

        $user = User::query()->where('user_name', trim($user_name))->first();
        if (!$user) {
            $user = new User();
            $user->user_name = $user_name;
            $user->save();
        }

        $trash_info = new TrashInfo();
        $trash_info->user_index = $user->user_id;
        $trash_info->trash_index = $trash->trash_id;
        $trash_info->trash_info_weight = $trash_info_weight;
        $trash_info->save();
        return Redirect::back()->with('success', 1)->withCookie(cookie('user_name', $user_name, 0, null, null, null, false));
    }
}
