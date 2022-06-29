<?php


namespace App\Http\Controllers\Admin;


use App\Exports\DataExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DataController extends Controller
{
    public function export(Request $request)
    {
        $from = $request->get("from", '');
        $to = $request->get("to", '');
        return Excel::download(new DataExport($from, $to), "data.".date('Ymd_His').'.xlsx');
    }
}
