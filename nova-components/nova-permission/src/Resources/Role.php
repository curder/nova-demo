<?php

namespace Curder\NovaPermission\Resources;

use App\Enums\PermissionsEnum;
use App\Enums\RolesEnum;
use Curder\NovaPermission\Fields\GroupCheckBoxListField;
use Curder\NovaPermission\Models\Permission as PermissionModel;
use Curder\NovaPermission\Models\Role as RoleModel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Nova;
use Laravel\Nova\Resource;

/**
 * @property string $guard_name
 * @property string $name
 * @property \Illuminate\Database\Eloquent\Collection $users
 */
class Role extends Resource
{
    /**
     * @var bool
     */
    public static $displayInNavigation = true;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = RoleModel::class;

    /**
     * The columns that should be searched.
     *
     * @var array<string>
     */
    public static $search = [
        'name',
    ];

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

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
     * Get the fields displayed by the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function fields(Request $request)
    {
        $guardOptions = collect(config('auth.guards'))
            ->mapWithKeys(function ($value, $key) {
                return [$key => $key];
            });
        $role_table = config('permission.table_names.roles');

        $userResource = Nova::resourceForModel(getModelForGuard($this->guard_name));

        // 权限选项
        $permission_options = PermissionModel::all()->map(function ($permission) {
            return [
                'group' => PermissionsEnum::from($permission->group)->label(),
                'option' => $permission->name,
                'label' => sprintf(
                    "%s - %s",
                    PermissionsEnum::from($permission->group)->label(),
                    PermissionsEnum::from($permission->name)->label()
                ),
            ];
        })->groupBy('group')
          ->toArray();

        return [
            ID::make('ID', 'id')
              ->rules('required')
              ->hideFromIndex(),

            Text::make(__('nova-permission::roles.name'), 'name')
                ->rules(['required', 'string', 'max:255'])
                ->creationRules('unique:'.$role_table)
                ->updateRules('unique:'.$role_table.',name,{{resourceId}}')
                ->onlyOnForms(),

            Text::make(__('nova-permission::roles.display_name'), function () {
                return RolesEnum::from($this->name)->label();
            }),

            Select::make(__('nova-permission::roles.guard_name'), 'guard_name')
                  ->options($guardOptions->toArray())
                  ->rules(['required', Rule::in($guardOptions)])
                  ->canSee(function ($request) {
                      return $request->user()->isSuperAdmin();
                  }),

            GroupCheckBoxListField::make(Permission::label(), 'prepared_permissions')
                                  ->withGroups()
                                  ->options($permission_options)
                                  ->help(__('nova-permission::permissions.role_related_permissions_help')),

            Text::make(__('nova-permission::permissions.user_count'), function () {
                return count($this->users);
            })->exceptOnForms(),

            MorphToMany::make($userResource::singularLabel(), 'users', $userResource),
        ];
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

    public static function label()
    {
        return __('nova-permission::resources.Role');
    }

    public static function singularLabel()
    {
        return __('nova-permission::resources.Roles');
    }

    /**
     * Get the logical group associated with the resource.
     *
     * @return string
     */
    public static function group(): string
    {
        return __('nova-permission::navigations.User & Role & Permission');
    }
}
