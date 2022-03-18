<?php

namespace Curder\NovaPermission\Actions;

use App\Models\User;
use Curder\NovaPermission\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use App\Enums\PermissionsEnum;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\InteractsWithQueue;

class PermissionsAttachToUser extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        /** @var User $user */
        $user = User::query()->find($fields['user']);

        foreach ($models as $model) {
            $user->givePermissionTo($model);
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        $users = User::get()->reject(function($user) {
            return $user->isSuperAdmin();
        })->pluck('name', 'id')
          ->toArray();

        return [
            Select::make(__('nova-permission::resources.Users'), 'user')
                  ->options($users)
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
        /** @var User $user */
        $user = $request->user();

        return $user->isSuperAdmin()
            || $user->hasPermissionTo(PermissionsEnum::PERMISSION_ATTACH_ANY_USERS->value)
            || $user->hasPermissionTo(PermissionsEnum::PERMISSION_ATTACH_USERS->value);
    }

    /**
     * Get the displayable name of the action.
     *
     * @return string
     */
    public function name(): string
    {
        return __('nova-permission::actions.permissions_attach_to_user');
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
