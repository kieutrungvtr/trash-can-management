<?php
/**
 * Warning: This class is generated automatically by schema_update
 *          !!! Do not touch or modify !!!
 */

namespace App\Models\Sql;

use Illuminate\Database\Eloquent\Model;
#---- Begin package usage -----#
use Illuminate\Support\Facades\Cache;
#---- Ended package usage -----#

class TrashType extends Model
{
    #---- Begin trait -----#
    
    #---- Ended trait -----#

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'trash_type';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'trash_type_id';

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
    const COL_TRASH_TYPE_ID = 'trash_type_id';

    /**
     * @var string
     */
    const COL_TRASH_TYPE_NAME = 'trash_type_name';

    /**
     * @var string
     */
    const COL_TRASH_TYPE_COLOR = 'trash_type_color';

    /**
     * @var string
     */
    const COL_TRASH_TYPE_CREATED_AT = 'trash_type_created_at';

    /**
     * @var string
     */
    const COL_TRASH_TYPE_UPDATED_AT = 'trash_type_updated_at';

    

    /**
     * @const string
     */
    const TABLE_NAME = 'trash_type';

    #---- Begin custom code -----#
    public static function getCacheList()
    {
        $data = Cache::get(self::TABLE_NAME, null);
        if (!$data) {
            $data = array();
            $trash_type_list = self::query()->get()->toArray();
            foreach ($trash_type_list as $trash_type) {
                $data[$trash_type[self::COL_TRASH_TYPE_ID]] = $trash_type;
            }
            Cache::put(self::TABLE_NAME, $data);
        }
        return $data;
    }
    public static function clearCache()
    {
        Cache::forget(self::TABLE_NAME);
    }
    #---- Ended custom code -----#
}