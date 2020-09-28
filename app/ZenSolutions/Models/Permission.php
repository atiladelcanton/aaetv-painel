<?php

namespace App\ZenSolutions\Models;

use Artesaos\Defender\Pivots\PermissionRolePivot;
use Artesaos\Defender\Pivots\PermissionUserPivot;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Model Permissions
 *
 * @version 1.0.0
 * @package App\ZenSolutions\Models
 */
class Permission extends Model implements \Artesaos\Defender\Contracts\Permission
{
    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->fillable = $fillable = [
            'name',
            'readable_name',
            'modules_id',
        ];

        parent::__construct($attributes);

        $this->table = config('defender.permission_table', 'permissions');
    }

    /**
     * Many-to-many permission-role relationship.
     *
     * @return BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(
            config('defender.role_model'),
            config('defender.permission_role_table'),
            config('defender.permission_key'),
            config('defender.role_key')
        )->withPivot('value', 'expires');
    }

    /**
     * Many-to-many permission-user relationship.
     *
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(
            config('defender.user_model'),
            config('defender.permission_user_table'),
            config('defender.permission_key'),
            'administrator_id'
        )->withPivot('value', 'expires');
    }

    /**
     * @param Model       $parent
     * @param array       $attributes
     * @param string      $table
     * @param bool        $exists
     * @param string|null $using
     *
     * @return PermissionUserPivot|Pivot
     */
    public function newPivot(Model $parent, array $attributes, $table, $exists, $using = null)
    {
        $userModel = app()['config']->get('defender.user_model');
        $roleModel = app()['config']->get('defender.role_model');

        if ($parent instanceof $userModel) {
            return PermissionUserPivot::fromAttributes($parent, $attributes, $table, $exists);
        }

        if ($parent instanceof $roleModel) {
            return PermissionRolePivot::fromAttributes($parent, $attributes, $table, $exists);
        }

        return parent::newPivot($parent, $attributes, $table, $exists);
    }
}
