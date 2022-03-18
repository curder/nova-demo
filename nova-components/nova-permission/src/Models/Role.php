<?php

namespace Curder\NovaPermission\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role as SpatieRole;

/**
 * Class Role.
 *
 * @property string $name
 * @property array $prepared_permissions
 * @property BelongsToMany $permissions
 */
class Role extends SpatieRole
{
    use SoftDeletes;
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['prepared_permissions'];

    /**
     * @return array
     */
    public function getPreparedPermissionsAttribute(): array
    {
        return $this->permissions->pluck('name')->toArray();
    }
}
