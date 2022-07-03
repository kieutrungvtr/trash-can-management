<?php
/**
 * Warning: This class is generated automatically by schema_update
 *          !!! Do not touch or modify !!!
 */

namespace App\Models\Sql;

use Illuminate\Database\Eloquent\Model;
#---- Begin package usage -----#
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
#---- Ended package usage -----#

class TrashInfo extends Model
{
    #---- Begin trait -----#

    #---- Ended trait -----#

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'trash_info';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'trash_info_id';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    public $timestamps = false;

    /**
     * @var string
     */
    const COL_TRASH_INFO_ID = 'trash_info_id';

    /**
     * @var string
     */
    const COL_USER_INDEX = 'user_index';

    /**
     * @var string
     */
    const COL_TRASH_INDEX = 'trash_index';

    /**
     * @var string
     */
    const COL_TRASH_INFO_WEIGHT = 'trash_info_weight';

    /**
     * @var string
     */
    const COL_TRASH_INFO_CREATED_AT = 'trash_info_created_at';

    /**
     * @var string
     */
    const COL_TRASH_INFO_UPDATED_AT = 'trash_info_updated_at';

    /**
     * @var string
     */
    const COL_TRASH_TYPE_INDEX = 'trash_type_index';

    /**
     * @var string
     */
    const COL_TRASH_LOCATION_INDEX = 'trash_location_index';

    /**
     * @var string
     */
    const COL_TRASH_GROUP_INDEX = 'trash_group_index';



    /**
     * @const string
     */
    const TABLE_NAME = 'trash_info';

    #---- Begin custom code -----#
    public static function reportByType($group_id, $from = null, $to = null)
    {
        $query = self::query()
            ->select([
                'trash_type_index',
                self::raw('sum(trash_info_weight) as total')
            ])
            ->groupBy('trash_type_index');
        if ($from) {
            $query->where('trash_info_created_at','>=', $from);
        }
        if ($to) {
            $query->where('trash_info_created_at','<=', $to);
        }
        if ($group_id) {
            $query->where('trash_group_index', $group_id);
        }
        $data = $query->get()->toArray();

        return array_column($data, 'total', 'trash_type_index');
    }

    public static function reportByWeek($from = null, $to = null)
    {

        $query = self::query()
            ->select([
                self::raw('YEARWEEK(trash_info_created_at, 3) as year_week'),
                'trash_group_index',
                self::raw('sum(trash_info_weight) as total')
            ]);
        if ($from) {
            $query->where('trash_info_created_at','>=', $from);
        }
        if ($to) {
            $query->where('trash_info_created_at','<=', $to);
        }
        $query
            ->groupBy('year_week')
            ->groupBy('trash_group_index')
            ->orderBy('year_week', 'asc')
            ->orderBy('trash_group_index', 'asc');

        return $query->get()->toArray();
    }

    public static function reportTypeWeek($from = null, $to = null)
    {
        $query = self::query()->select([
            self::raw("min(trash_info_created_at) as min_date"),
            self::raw("max(trash_info_created_at) as max_date"),
        ]);
        if ($from) {
            $query->where('trash_info_created_at','>=', $from);
        }
        if ($to) {
            $query->where('trash_info_created_at','<=', $to);
        }
        $min_max_data = $query->get()->first();
        $min_date = $min_max_data['min_date'] ?? '';
        $max_date = $min_max_data['max_date'] ?? '';
        if(!$min_date) return array();
        $min_week = date("oW", strtotime($min_date));
        $max_week = date("oW", strtotime($max_date));
        $week_diff = TrashInfo::week_diff($min_week, $max_week);

        $query = self::query()
            ->select([
                'trash_type_index',
                self::raw("sum(trash_info_weight)/$week_diff as total")
            ]);
        if ($from) {
            $query->where('trash_info_created_at','>=', $from);
        }
        if ($to) {
            $query->where('trash_info_created_at','<=', $to);
        }
        $query
            ->groupBy('trash_type_index')
            ->orderBy('trash_type_index', 'asc');
        $raw_data = $query->get()->toArray();
        return array_column($raw_data, 'total', 'trash_type_index');
    }

    public static function reportTypeDate($from = null, $to = null)
    {
        $query = self::query()->select([
            self::raw("min(trash_info_created_at) as min_date"),
            self::raw("max(trash_info_created_at) as max_date"),
        ]);
        if ($from) {
            $query->where('trash_info_created_at','>=', $from);
        }
        if ($to) {
            $query->where('trash_info_created_at','<=', $to);
        }
        $min_max_data = $query->get()->first();
        $min_date = $min_max_data['min_date'] ?? '';
        $max_date = $min_max_data['max_date'] ?? '';
        if(!$min_date) return array();
        $date_diff = date_diff(date_create($min_date),date_create($max_date))->days + 1;

        $query = self::query()
            ->select([
                'trash_type_index',
                self::raw("sum(trash_info_weight)/$date_diff as total")
            ]);
        if ($from) {
            $query->where('trash_info_created_at','>=', $from);
        }
        if ($to) {
            $query->where('trash_info_created_at','<=', $to);
        }
        $query
            ->groupBy('trash_type_index')
            ->orderBy('trash_type_index', 'asc');
        $raw_data = $query->get()->toArray();
        return array_column($raw_data, 'total', 'trash_type_index');
    }

    public static function week_diff($year_week1, $year_week2)
    {
        if ($year_week2 < $year_week1) return self::week_diff($year_week2, $year_week1);
        $year1 = (int)substr($year_week1, 0, 4);
        $year2 = (int)substr($year_week2, 0, 4);
        $week1 = (int)substr($year_week1, 4, 2);
        $week2 = (int)substr($year_week2, 4, 2);
        if ($year1 == $year2) {
            return (int)$week2 - (int)$week1 + 1;
        }
        else {
            $diff_year = $year2 - ($year1 + 1);
            return $diff_year * 52 + $week2 + (52 - $week1) + 1;
        }
    }
    public static function week_plus($year_week, $plus_num)
    {
        $year = (int)substr($year_week, 0, 4);
        $week = (int)substr($year_week, 4, 2);
        $cal_year = $year + floor(($week + $plus_num) / 53);
        $cal_week = ($week + $plus_num) % 53;

        return $s = sprintf('%d%02d', $cal_year, $cal_week);

    }
    public static function maxUser($group= null, $type= null, $from = null, $to = null)
    {
        $query = self::query()
            ->select([
                'user_index',
                self::raw("sum(trash_info_weight) as total")
            ]);
        if ($from) {
            $query->where('trash_info_created_at','>=', $from);
        }
        if ($to) {
            $query->where('trash_info_created_at','<=', $to);
        }
        if ($group) {
            $query->where('trash_group_index',$group);
        }
        if ($type) {
            $query->where('trash_type_index',$type);
        }
        $query
            ->groupBy('user_index')
            ->orderBy('total', 'desc');

        $user_info = $query->get()->first();
        $user = User::query()->find($user_info["user_index"]??0)->toArray();
        $user['total'] = $user_info['total'];
        return $user;
    }

    public static function maxUserType($trash_type_list, $from = null, $to = null)
    {
        $result = [];
        foreach ($trash_type_list as $trash_type) {
            $trash_type_id = $trash_type['trash_type_id'];
            $result[$trash_type_id] = self::maxUser(null, $trash_type_id, $from, $to);
        }
        return $result;
    }

    public static function maxUserGroup($trash_group_list, $from = null, $to = null)
    {
        $result = [];
        foreach ($trash_group_list as $trash_group) {
            $trash_group_id = $trash_group['trash_group_id'];
            $result[$trash_group_id] = self::maxUser($trash_group_id, null, $from, $to);
        }
        return $result;
    }

    public static function maxTrashType($from = null, $to = null)
    {
        $query = self::query()
            ->select([
                'trash_type_index',
                self::raw("sum(trash_info_weight) as total")
            ]);
        if ($from) {
            $query->where('trash_info_created_at','>=', $from);
        }
        if ($to) {
            $query->where('trash_info_created_at','<=', $to);
        }
        $query
            ->groupBy('trash_type_index')
            ->orderBy('total', 'desc');

        $trash_type_info = $query->get()->first();
        return $trash_type_info;
    }

    public static function trashDate($from = null, $to = null, $page = 1, $limit = 30)
    {
        $query = self::query()
            ->select([
                self::raw("trash_type_index"),
                self::raw("date(trash_info_created_at) as `date`"),
                self::raw("sum(trash_info_weight) as total")
            ]);
        if ($from) {
            $query->where('trash_info_created_at','>=', $from);
        }
        if ($to) {
            $query->where('trash_info_created_at','<=', $to);
        }
        $query
            ->groupBy('trash_type_index')
            ->groupBy('date');

        $result = [];
        $trash_data = $query->get()->toArray();
        foreach ($trash_data as $trash) {
            $result[$trash["date"]][$trash['trash_type_index']] = $trash['total'];
        }
        return $result;
    }


    public static function getExport($from = null, $to = null, $location_id = null, $group_id = null, $type = null, $page = 0, $limit = 20)
    {
        $query = self::getExportQuery($from, $to, $location_id, $group_id, $type, $page, $limit);

        return $query->get()->toArray();
    }
    public static function getExportQuery($from = null, $to = null, $location_id = null, $group_id = null, $type = null, $page = 0, $limit = 20)
    {
        $query = self::query();
        if ($from) {
            $query->where('trash_info_created_at','>=', $from);
        }
        if ($to) {
            $query->where('trash_info_created_at','<=', $to);
        }
        if ($location_id) {
            $query->where('trash_location_index','=', $location_id);
        }
        if ($group_id) {
            $query->where('trash_group_index','=', $group_id);
        }
        if ($type) {
            $query->where('trash_type_index','=', $type);
        }

        if ($page) {
            $query->limit($limit)
                ->offset($limit*($page-1));
        }
        return $query;
    }
    #---- Ended custom code -----#
}
