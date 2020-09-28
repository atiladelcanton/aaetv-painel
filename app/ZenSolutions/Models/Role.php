<?php


namespace App\ZenSolutions\Models;


use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'type',
        'name'
    ];
    protected $with = ['permissions'];

    /**
     * Many-to-many permission-user relationship.
     *
     * @return BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(
            config('defender.permission_model'),
            config('defender.permission_role_table'),
            'role_id',
            config('defender.permission_key')
        )->withPivot('value', 'expires');
    }
}
