<?php


namespace App\Http\Controllers\Admin;


use App\Exports\Chart1Export;
use App\Exports\Chart2Export;
use App\Exports\Chart3Export;
use App\Exports\DashboardExport;
use App\Exports\DataExport;
use App\Http\Controllers\Controller;
use App\Models\Sql\TrashGroup;
use App\Models\Sql\TrashInfo;
use App\Models\Sql\TrashLocation;
use App\Models\Sql\TrashType;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StatisticsController extends Controller
{
    public function trashGroup(Request $request)
    {
        $export = $request->get('export', 0);
        if ($export) {
            return Excel::download(new Chart1Export($request), str_replace(' ', '', __('Chart 1')).".".date('Ymd_His').'.xlsx');
        }
        $from = $request->get("from", date('Y-m-d', time() - 86400*29));
        $to = $request->get("to", date('Y-m-d'));
        $group_id = $request->get("group", 0);
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
        $group_name = TrashGroup::query()->find($group_id)["trash_group_name"] ?? '';

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
            'from' => $from,
            'to' => $to,
            'group_id' => $group_id,
            'group_name' => $group_name,
            'chart_data' => $chart_data,
            'trash_group_list' => $trash_group_list,
            'trash_location_list' => $trash_location_list
        ]);
    }


    public function trashGroupType(Request $request)
    {
        $export = $request->get('export', 0);
        if ($export) {
            return Excel::download(new Chart2Export($request), str_replace(' ', '', __('Chart 2')).".".date('Ymd_His').'.xlsx');
        }
        $from = $request->get("from", date('Y-m-d', time() - 86400*29));
        $to = $request->get("to", date('Y-m-d'));

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
        $export = $request->get('export', 0);
        if ($export) {
            return Excel::download(new Chart3Export($request), str_replace(' ', '', __('Chart 3')).".".date('Ymd_His').'.xlsx');
        }
        $from = $request->get("from", date('Y-m-d', time() - 86400*29));
        $to = $request->get("to", date('Y-m-d'));

        $trash_group_list = TrashGroup::getCacheList();
        $report = TrashInfo::reportByWeek($from, $to);

        $labels = array();
        $week_list = array_unique(array_column($report, 'year_week'));
        $min_week = $max_week = 1;
        if ($week_list) {
            $min_week = min($week_list);
            $max_week = max($week_list);
        }
        $week_diff = TrashInfo::week_diff($min_week, $max_week);
        for ($week = 1; $week <= $week_diff; $week++) {
            $labels[] = __('Tuần ') . $week;
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
                for ($week = 1; $week <= $week_diff; $week++) {
                    $week_str = TrashInfo::week_plus($min_week, $week-1);
                    $datasets_builder[$trash_group_id][$week_str] = $datasets_builder[$trash_group_id][$week_str] ?? 0;
                }
                $trash_group_names[$trash_group_id] = $trash_group["trash_group_name"];
                ksort($datasets_builder[$trash_group_id]);
            }
        }
        ksort($datasets_builder);

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

    public function dashboard(Request $request)
    {
        $from = $request->get("from", date('Y-m-d', time() - 86400*29));
        $to = $request->get("to", date('Y-m-d'));
        $page = $request->get("page", 1);
        $limit = $request->get("limit", 30);
        $trash_type_list = TrashType::getCacheList();
        $trash_location_list = TrashLocation::getCacheList();
        $trash_group_list = TrashGroup::getCacheList();

        $date_diff = date_diff(date_create($from),date_create($to))->days;
        $date_start = date('Y-m-d', strtotime($from.' +'.( ($page-1)*$limit).' day'));
        $date_end = min(date('Y-m-d', strtotime($from.' +'.( ($page)*$limit-1).' day')), $to);
        $max_page = floor($date_diff / $limit + 1);

        $date_totals = TrashInfo::trashDate($date_start, $date_end, $page, 30);
        $date_totals_list = [];
        $min_date = $date_start;
        $max_date = $date_end;
        for ($c_date = $min_date; $c_date <= $max_date; $c_date = date("Y-m-d", strtotime($c_date.' +1 day'))) {
            $date_totals[$c_date] = $date_totals[$c_date] ?? array();
            $date_totals_list[] = $c_date;
        }

        $max_trash_type_info = TrashInfo::maxTrashType();

        $request_parameter = $request->toArray();
        unset($request_parameter['page']);
        return view('admin.statistics.dashboard', array(
            'trash_type_list' => $trash_type_list,
            'trash_location_list' => $trash_location_list,
            'trash_group_list' => $trash_group_list,
            'avg_day_type_report' => TrashInfo::reportTypeDate(),
            'avg_week_type_report' => TrashInfo::reportTypeWeek(),
            'max_trash_type_id' => $max_trash_type_info["trash_type_index"] ?? 0,
            'max_trash_type_kg' => $max_trash_type_info["total"] ?? 0,
            'date_totals' => $date_totals,
            'date_totals_list' => $date_totals_list,
            'from' => $from,
            'to' => $to,
            'page' => $page,
            'max_page' => $max_page,
            'page_uri' => "/admin/stats/dashboard?".http_build_query($request_parameter),
        ));
    }

    public function export(Request $request)
    {
        return Excel::download(new DashboardExport(), "dashboard.".date('Ymd_His').'.xlsx');
    }

    public static function ConvertColorName($color_name)
    {
        $data = "{\"aliceblue\":\"#f0f8ff\",\"antiquewhite\":\"#faebd7\",\"aqua\":\"#00ffff\",\"aquamarine\":\"#7fffd4\",\"azure\":\"#f0ffff\",
    \"beige\":\"#f5f5dc\",\"bisque\":\"#ffe4c4\",\"black\":\"#000000\",\"blanchedalmond\":\"#ffebcd\",\"blue\":\"#0000ff\",\"blueviolet\":\"#8a2be2\",\"brown\":\"#a52a2a\",\"burlywood\":\"#deb887\",
    \"cadetblue\":\"#5f9ea0\",\"chartreuse\":\"#7fff00\",\"chocolate\":\"#d2691e\",\"coral\":\"#ff7f50\",\"cornflowerblue\":\"#6495ed\",\"cornsilk\":\"#fff8dc\",\"crimson\":\"#dc143c\",\"cyan\":\"#00ffff\",
    \"darkblue\":\"#00008b\",\"darkcyan\":\"#008b8b\",\"darkgoldenrod\":\"#b8860b\",\"darkgray\":\"#a9a9a9\",\"darkgreen\":\"#006400\",\"darkkhaki\":\"#bdb76b\",\"darkmagenta\":\"#8b008b\",\"darkolivegreen\":\"#556b2f\",
    \"darkorange\":\"#ff8c00\",\"darkorchid\":\"#9932cc\",\"darkred\":\"#8b0000\",\"darksalmon\":\"#e9967a\",\"darkseagreen\":\"#8fbc8f\",\"darkslateblue\":\"#483d8b\",\"darkslategray\":\"#2f4f4f\",\"darkturquoise\":\"#00ced1\",
    \"darkviolet\":\"#9400d3\",\"deeppink\":\"#ff1493\",\"deepskyblue\":\"#00bfff\",\"dimgray\":\"#696969\",\"dodgerblue\":\"#1e90ff\",
    \"firebrick\":\"#b22222\",\"floralwhite\":\"#fffaf0\",\"forestgreen\":\"#228b22\",\"fuchsia\":\"#ff00ff\",
    \"gainsboro\":\"#dcdcdc\",\"ghostwhite\":\"#f8f8ff\",\"gold\":\"#ffd700\",\"goldenrod\":\"#daa520\",\"gray\":\"#808080\",\"green\":\"#008000\",\"greenyellow\":\"#adff2f\",
    \"honeydew\":\"#f0fff0\",\"hotpink\":\"#ff69b4\",
    \"indianred \":\"#cd5c5c\",\"indigo\":\"#4b0082\",\"ivory\":\"#fffff0\",\"khaki\":\"#f0e68c\",
    \"lavender\":\"#e6e6fa\",\"lavenderblush\":\"#fff0f5\",\"lawngreen\":\"#7cfc00\",\"lemonchiffon\":\"#fffacd\",\"lightblue\":\"#add8e6\",\"lightcoral\":\"#f08080\",\"lightcyan\":\"#e0ffff\",\"lightgoldenrodyellow\":\"#fafad2\",
    \"lightgrey\":\"#d3d3d3\",\"lightgreen\":\"#90ee90\",\"lightpink\":\"#ffb6c1\",\"lightsalmon\":\"#ffa07a\",\"lightseagreen\":\"#20b2aa\",\"lightskyblue\":\"#87cefa\",\"lightslategray\":\"#778899\",\"lightsteelblue\":\"#b0c4de\",
    \"lightyellow\":\"#ffffe0\",\"lime\":\"#00ff00\",\"limegreen\":\"#32cd32\",\"linen\":\"#faf0e6\",
    \"magenta\":\"#ff00ff\",\"maroon\":\"#800000\",\"mediumaquamarine\":\"#66cdaa\",\"mediumblue\":\"#0000cd\",\"mediumorchid\":\"#ba55d3\",\"mediumpurple\":\"#9370d8\",\"mediumseagreen\":\"#3cb371\",\"mediumslateblue\":\"#7b68ee\",
    \"mediumspringgreen\":\"#00fa9a\",\"mediumturquoise\":\"#48d1cc\",\"mediumvioletred\":\"#c71585\",\"midnightblue\":\"#191970\",\"mintcream\":\"#f5fffa\",\"mistyrose\":\"#ffe4e1\",\"moccasin\":\"#ffe4b5\",
    \"navajowhite\":\"#ffdead\",\"navy\":\"#000080\",
    \"oldlace\":\"#fdf5e6\",\"olive\":\"#808000\",\"olivedrab\":\"#6b8e23\",\"orange\":\"#ffa500\",\"orangered\":\"#ff4500\",\"orchid\":\"#da70d6\",
    \"palegoldenrod\":\"#eee8aa\",\"palegreen\":\"#98fb98\",\"paleturquoise\":\"#afeeee\",\"palevioletred\":\"#d87093\",\"papayawhip\":\"#ffefd5\",\"peachpuff\":\"#ffdab9\",\"peru\":\"#cd853f\",\"pink\":\"#ffc0cb\",\"plum\":\"#dda0dd\",\"powderblue\":\"#b0e0e6\",\"purple\":\"#800080\",
    \"rebeccapurple\":\"#663399\",\"red\":\"#ff0000\",\"rosybrown\":\"#bc8f8f\",\"royalblue\":\"#4169e1\",
    \"saddlebrown\":\"#8b4513\",\"salmon\":\"#fa8072\",\"sandybrown\":\"#f4a460\",\"seagreen\":\"#2e8b57\",\"seashell\":\"#fff5ee\",\"sienna\":\"#a0522d\",\"silver\":\"#c0c0c0\",\"skyblue\":\"#87ceeb\",\"slateblue\":\"#6a5acd\",\"slategray\":\"#708090\",\"snow\":\"#fffafa\",\"springgreen\":\"#00ff7f\",\"steelblue\":\"#4682b4\",
    \"tan\":\"#d2b48c\",\"teal\":\"#008080\",\"thistle\":\"#d8bfd8\",\"tomato\":\"#ff6347\",\"turquoise\":\"#40e0d0\",
    \"violet\":\"#ee82ee\",
    \"wheat\":\"#f5deb3\",\"white\":\"#ffffff\",\"whitesmoke\":\"#f5f5f5\",
    \"yellow\":\"#ffff00\",\"yellowgreen\":\"#9acd32\"}";
        $data = json_decode($data, true);
        return $data[$color_name];
    }
}
