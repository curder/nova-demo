<?php

namespace  Curder\NovaPermission\Actions;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use App\Enums\PermissionsEnum;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Curder\NovaPermission\Models\Role;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;

/**
 * Class AttachToRole.
 */
class AttachToRole extends Action
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
        return [
            Select::make(__('nova-permission::resources.Roles'), 'role')
                  ->options(function () {
                      return Role::getModel()->get()->pluck('name', 'id');
                  })
                  ->displayUsingLabels(),
        ];
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    public function authorizedToSee(Request $request): bool
    {
        $user = $request->user();

        return $user->isSuperAdmin()
            || $user->hasPermissionTo(PermissionsEnum::PERMISSION_ATTACH_ANY_ROLES)
            || $user->hasPermissionTo(PermissionsEnum::PERMISSION_ATTACH_ROLES);
    }

    /**
     * Get the displayable name of the action.
     *
     * @return string
     */
    public function name()
    {
        return __('nova-permission::actions.attach_to_role');
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
