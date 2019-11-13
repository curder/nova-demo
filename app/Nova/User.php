<?php

namespace App\Nova;

use Laravel\Nova\Panel;
use App\Enums\RolesEnum;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use App\Enums\PermissionsEnum;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\BooleanGroup;
use Curder\NovaPermission\Models\Permission;

class User extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\\Models\\User';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name', 'email',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Gravatar::make(__('users.avatarLabel')),

            Text::make(__('users.nameLabel'), 'name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make(__('users.emailLabel'), 'email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Password::make(__('users.passwordLabel'), 'password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:8')
                ->updateRules('nullable', 'string', 'min:8'),

            new Panel('Role & Permission', $this->getRoleAndPermissionFields()),

//            BooleanGroup::make('Permissions')->options(
//                Permission::get()->pluck('name', 'id')->toArray()
//            ),
        ];
    }

    public function getRoleAndPermissionFields(): array
    {
        $roles = \Curder\NovaPermission\Models\Role::get()->pluck('name', 'id');

        return [
            BooleanGroup::make(__('nova-permission::resources.Roles'), 'roles')
                        ->options(function () use ($roles) {
                            return $roles->mapWithKeys(function ($role, $id) {
                                return [$id => RolesEnum::getDescription($role)];
                            });
                        })->resolveUsing(function () use ($roles) {
                            return $roles->mapWithKeys(function ($role, $id) {
                                return [$id => $this->hasRole($role)];
                            });
                        })->exceptOnForms(),

            BooleanGroup::make(__('nova-permission::resources.Roles'), 'roles')
                        ->options(function () use ($roles) {
                            return $roles->mapWithKeys(function ($role, $id) {
                                return [$id => RolesEnum::getDescription($role)];
                            });
                        })->resolveUsing(function () use ($roles) {
                            return $roles->mapWithKeys(function ($role, $id) {
                                return [$id => $this->hasRole($role)];
                            });
                        })->onlyOnForms()->canSee(function () {
                            /* @var \App\Models\User $user */
                            $user = request()->user();
                            return $user->isSuperAdmin() || $user->can(PermissionsEnum::ROLE_ATTACH_USERS);
                        }),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('users.label');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('users.singularLabel');
    }
}
