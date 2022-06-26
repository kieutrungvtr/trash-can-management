<?php
/**
 * Warning: This class is generated automatically by schema_update
 *          !!! Do not touch or modify !!!
 */

namespace App\Models\Sql;

use Illuminate\Database\Eloquent\Model;
#---- Begin package usage -----#

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
            ->where('trash_group_index', $group_id)
            ->groupBy('trash_type_index');
        if ($from) {
            $query->where('trash_info_created_at','>=', $from);
        }
        if ($to) {
            $query->where('trash_info_created_at','<=', $to);
        }
        $data = $query->get()->toArray();

        return array_column($data, 'total', 'trash_type_index');
    }

    public static function reportByWeek($from = null, $to = null)
    {

        $query = self::query()
            ->select([
                self::raw('YEARWEEK(trash_info_created_at) as year_week'),
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
    #---- Ended custom code -----#
}
