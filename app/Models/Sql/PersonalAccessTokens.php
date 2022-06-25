<?php
/**
 * Warning: This class is generated automatically by schema_update
 *          !!! Do not touch or modify !!!
 */

namespace App\Models\Sql;

use Illuminate\Database\Eloquent\Model;
#---- Begin package usage -----#

#---- Ended package usage -----#

class PersonalAccessTokens extends Model
{
    #---- Begin trait -----#
    
    #---- Ended trait -----#

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'personal_access_tokens';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

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
    const COL_ID = 'id';

    /**
     * @var string
     */
    const COL_TOKENABLE_TYPE = 'tokenable_type';

    /**
     * @var string
     */
    const COL_TOKENABLE_ID = 'tokenable_id';

    /**
     * @var string
     */
    const COL_NAME = 'name';

    /**
     * @var string
     */
    const COL_TOKEN = 'token';

    /**
     * @var string
     */
    const COL_ABILITIES = 'abilities';

    /**
     * @var string
     */
    const COL_LAST_USED_AT = 'last_used_at';

    /**
     * @var string
     */
    const COL_CREATED_AT = 'created_at';

    /**
     * @var string
     */
    const COL_UPDATED_AT = 'updated_at';

    

    /**
     * @const string
     */
    const TABLE_NAME = 'personal_access_tokens';

    #---- Begin custom code -----#
    
    #---- Ended custom code -----#
}