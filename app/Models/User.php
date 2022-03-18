<?php

namespace App\Models;

use App\Enums\RolesEnum;
use App\Enums\UsersEnum;
use Curder\NovaPermission\Models\SyncRoleAndPermission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasFactory;
    use HasRoles;
    use Notifiable;
    use SoftDeletes;
    use SyncRoleAndPermission;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<string>
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * 是否超级用户.
     *
     * @return bool
     */
    public function isSuperAdmin(): bool
    {
        return $this->hasRole(RolesEnum::SUPER_ADMIN);
    }

    /**
     * @param ?string $impersonated
     *
     * @return bool
     */
    public function canImpersonate($impersonated = null): bool
    {
        return in_array($this->email, [UsersEnum::SUPER], true);
    }
}
