<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Sql\TrashGroup;
use App\Models\Sql\TrashInfo;
use App\Models\Sql\TrashLocation;
use App\Models\Sql\TrashType;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function trashGroup(Request $request)
    {
        $group_id = $request->get("group", 1);
        $trash_type_list = TrashType::getCacheList();
        $trash_group_list = TrashGroup::getCacheList();
        $trash_location_list = TrashLocation::getCacheList();
        $report = TrashInfo::reportByType($group_id);
        $labels = array();
        $data = array();
        $color = array();
        foreach ($trash_type_list as $trash_type_id => $trash_type) {
            $labels[] = $trash_type["trash_type_name"];
            $data[] = $report[$trash_type["trash_type_id"]] ?? 0;
            $color[] = $trash_type["trash_type_color"];
        }

        $datasets[] = array(
            "label" => "kg",
            'data' => $data,
            'backgroundColor' => $color,
            'borderColor' => $color,
            'borderWidth' => 1,
            'fill' => false,
        );
        $chart_data = array(
            "labels" => $labels,
            "datasets" => $datasets,
        );

        return view('admin.statistics.chart1', ['chart_data' => $chart_data, 'trash_group_list' => $trash_group_list, 'trash_location_list' => $trash_location_list]);
    }
}
