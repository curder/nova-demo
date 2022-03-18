<?php

namespace  Curder\NovaPermission\Actions;

use App\Enums\RolesEnum;
use Curder\NovaPermission\Models\Role;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;

/**
 * 给角色赋予权限
 *
 * Class AttachToRole.
 */
class PermissionsAttachToRole extends Action
{
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Perform the action on the given models.
     *
     * @param \Laravel\Nova\Fields\ActionFields $fields
     * @param \Illuminate\Support\Collection    $models
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $role = Role::getModel()->find($fields['role']);
        foreach ($models as $model) {
            $role->givePermissionTo($model);
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields(): array
    {
        $roles = Role::getModel()
                     ->where('name', '!=', RolesEnum::SuperAdmin)
                     ->get()
                     ->pluck('name', 'id');

        return [
            Select::make(__('nova-permission::resources.Roles'), 'role')
                  ->options($roles)
                  ->displayUsingLabels(),
        ];
    }

    /**
     * Get the displayable name of the action.
     *
     * @return string
     */
    public function name()
    {
        return __('nova-permission::actions.permissions_attach_to_role');
    }

    /**
     * Get the URI key for the action.
     *
     * @return string
     */
    public function uriKey()
    {
        return Str::slug(class_basename($this));
    }
}
