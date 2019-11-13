<?php

namespace App\Models;

use App\Enums\RolesEnum;
use Curder\NovaPermission\Models\SyncRole;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 *
 * @property integer id
 * @property string name
 * @property string email
 * @property string password
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasRoles;
    use Notifiable;
    use SoftDeletes;
    use SyncRole;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * 是否超级用户.
     *
     * @return bool
     */
    public function isSuperAdmin()
    {
        return $this->hasRole(RolesEnum::SUPER_ADMIN_MANAGER);
    }
}
