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
        $from = $request->get('from', '');
        $to = $request->get('to', '');
        $group_id = $request->get("group", 1);
        $trash_type_list = TrashType::getCacheList();
        $trash_group_list = TrashGroup::getCacheList();
        $trash_location_list = TrashLocation::getCacheList();
        $report = TrashInfo::reportByType($group_id, $from, $to);
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

        return view('admin.statistics.chart1', [
            'from' => $from, 'to' => $to, 'group_id' => $group_id,
            'chart_data' => $chart_data, 'trash_group_list' => $trash_group_list, 'trash_location_list' => $trash_location_list]);
    }


    public function trashGroupType(Request $request)
    {
        $from = $request->get('from', '');
        $to = $request->get('to', '');

        $trash_type_list = TrashType::getCacheList();
        $trash_group_list = TrashGroup::getCacheList();
        $trash_location_list = TrashLocation::getCacheList();

        $labels = array();
        $datasets_builder = array();
        foreach ($trash_group_list as $trash_location_id => $trash_group_data) {
            foreach ($trash_group_data as $trash_group_id => $trash_group) {
                $group_id = $trash_group_id;
                $labels[$trash_group_id] = $trash_group["trash_group_name"];
                $report = TrashInfo::reportByType($group_id, $from, $to);
                foreach ($trash_type_list as $trash_type_id => $trash_type) {
                    $datasets_builder[$trash_type_id][$trash_group_id] = $report[$trash_type_id] ?? 0;
                }
            }
        }
        $datasets = array();
        foreach ($datasets_builder as $trash_type_id => $datasets_data) {
            $trash_type = $trash_type_list[$trash_type_id];
            $datasets[] = array(
                "label" => $trash_type["trash_type_name"],
                'data' => array_values($datasets_data),
                'backgroundColor' => $trash_type["trash_type_color"],
                'borderColor' => $trash_type["trash_type_color"],
                'borderWidth' => 1,
                'fill' => false,
            );
        }
        ksort($labels);

        $chart_data = array(
            "labels" => array_values($labels),
            "datasets" => $datasets,
        );

        return view('admin.statistics.chart2', [
            'from' => $from, 'to' => $to,
            'chart_data' => $chart_data, 'trash_group_list' => $trash_group_list, 'trash_location_list' => $trash_location_list]);
    }


    public function trashLineWeek(Request $request)
    {
        $from = $request->get('from', '');
        $to = $request->get('to', '');

        $trash_group_list = TrashGroup::getCacheList();
        $report = TrashInfo::reportByWeek($from, $to);

        $week_list = array_unique(array_column($report, 'year_week'));
        $min_week = $max_week = 0;
        if ($week_list) {
            $min_week = min($week_list);
            $max_week = max($week_list);
        }
        $labels = array();
        for ($week = $min_week; $week <= $max_week; $week++) {
            $labels[] = __('Tuần ') . ($week - $min_week + 1);
        }

        $datasets_builder = array();
        foreach ($report as $report_data) {
            $year_week = $report_data["year_week"];
            $trash_group_id = $report_data["trash_group_index"];
            $datasets_builder[$trash_group_id][$year_week] = $report_data['total'];
        }
        $trash_group_names = array();
        foreach ($trash_group_list as $trash_location_id => $trash_group_data) {
            foreach ($trash_group_data as $trash_group_id => $trash_group) {
                for ($week = $min_week; $week <= $max_week; $week++) {
                    $datasets_builder[$trash_group_id][$week] = $datasets_builder[$trash_group_id][$week] ?? 0;
                }
                $trash_group_names[$trash_group_id] = $trash_group["trash_group_name"];
                ksort($datasets_builder[$trash_group_id]);
            }
        }

        $datasets = array();
        $color_list = $this->dynamicColors(count($datasets_builder));
        foreach ($datasets_builder as $trash_group_id => $datasets_data) {
            $color = array_pop($color_list);
            $datasets[] = array(
                "label" => $trash_group_names[$trash_group_id],
                'data' => array_values($datasets_data),
                'backgroundColor' => 'transparent',
                'borderColor' => $color,
                'fill' => false,
                'tension' => 0,
                'type' => 'line'
            );
        }

        $chart_data = array(
            "labels" => array_values($labels),
            "datasets" => $datasets,
        );
        return view('admin.statistics.chart3', ['chart_data' => $chart_data, 'from' => $from, 'to' => $to]);
    }


    private function dynamicColors($num = 1)
    {
        $count = 0;
        $color_check = array();
        while ($count < $num) {
            $r = floor(mt_rand(0, 25500) / 100);
            $g = floor(mt_rand(0, 25500) / 100);
            $b = floor(mt_rand(0, 25500) / 100);
            $color = "rgb($r, $g, $b)";
            if (isset($color_check[$color])) continue;
            $color_check[$color] = 1;
            $count++;
        }
        return array_keys($color_check);
    }

}
