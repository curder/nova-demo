<?php

namespace App\Nova;

use App\Models\User as UserModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Vyuldashev\NovaPermission\Permission;
use Vyuldashev\NovaPermission\Role;

/**
 * Class User
 *
 * @property UserModel $resource
 */
class User extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = UserModel::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array<string>
     */
    public static $search = [
        'id', 'name', 'email',
    ];

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            // Gravatar::make(__('users.avatarLabel')),

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

            MorphToMany::make(__('users.roles'), 'roles', Role::class),
            MorphToMany::make(__('users.permissions'), 'permissions', Permission::class),

            // new Panel(__('users.groupLabel'), $this->getRoleAndPermissionFields()),

            //            BooleanGroup::make('Permissions')->options(
            //                Permission::get()->pluck('name', 'id')->toArray()
            //            ),
        ];
    }

    /**
     * Get the cards available for the request.
     */
    public function cards(Request $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     */
    public function filters(Request $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     */
    public function lenses(Request $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     */
    public function actions(Request $request): array
    {
        return [];
    }

    /**
     * Get the displayable label of the resource.
     */
    public static function label(): string
    {
        return __('users.label');
    }

    /**
     * Get the displayable singular label of the resource.
     */
    public static function singularLabel(): string
    {
        return __('users.singularLabel');
    }

    /**
     * Get the logical group associated with the resource.
     */
    public static function group(): string
    {
        return __('users.groupLabel');
    }
}
