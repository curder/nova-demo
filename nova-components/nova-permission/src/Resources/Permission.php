<?php

namespace Curder\NovaPermission\Resources;

use Curder\NovaPermission\Actions\PermissionsAttachToRole;
use Curder\NovaPermission\Actions\PermissionsAttachToUser;
use Laravel\Nova\Nova;
use Laravel\Nova\Resource;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Illuminate\Validation\Rule;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\BelongsToMany;
use Curder\NovaPermission\Models\Permission as PermissionModel;
use App\Enums\PermissionsEnum;

/**
 * Class Permission
 *
 * @package Curder\NovaPermission\Nova
 */
class Permission extends Resource
{
    /**
     * @var mixed
     */
    public static $displayInNavigation = true;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = PermissionModel::class;

    /**
     * The columns that should be searched.
     *
     * @var array
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
    public function actions(Request $request) : array
    {
        return [
            PermissionsAttachToRole::make()
                ->canSee(function ($request) {
                    $user = $request->user();

                    return $user->isSuperAdmin()
                        || $user->hasPermissionTo(PermissionsEnum::PERMISSION_ATTACH_ANY_ROLES)
                        || $user->hasPermissionTo(PermissionsEnum::PERMISSION_ATTACH_ROLES);
                })->canRun(function ($request, $model) {
                    $user = $request->user();

                    return $user->isSuperAdmin()
                        || $user->hasPermissionTo(PermissionsEnum::PERMISSION_ATTACH_ANY_ROLES)
                        || $user->hasPermissionTo(PermissionsEnum::PERMISSION_ATTACH_ROLES);
                }),
            PermissionsAttachToUser::make()
                ->canSee(function ($request) {
                    $user = $request->user();

                    return $user->isSuperAdmin()
                        || $user->hasPermissionTo(PermissionsEnum::PERMISSION_ATTACH_ANY_USERS)
                        || $user->hasPermissionTo(PermissionsEnum::PERMISSION_ATTACH_USERS);
                })->canRun(function ($request, $model) {
                    $user = $request->user();

                    return $user->isSuperAdmin()
                        || $user->hasPermissionTo(PermissionsEnum::PERMISSION_ATTACH_ANY_USERS)
                        || $user->hasPermissionTo(PermissionsEnum::PERMISSION_ATTACH_USERS);
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
     * Get the fields displayed by the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function fields(Request $request)
    {
        $guardOptions = collect(config('auth.guards'))->mapWithKeys(function ($value, $key) {
            return [$key => $key];
        });

        $permission_table = config('permission.table_names.permissions');

        $userResource = Nova::resourceForModel(getModelForGuard($this->guard_name));

        return [
            ID::make('Id', 'id')
              ->rules('required')
              ->hideFromIndex(),

            Text::make(__('nova-permission::permissions.name'), 'name')
                ->rules(['required', 'string', 'max:255'])
                ->creationRules('unique:'.$permission_table)
                ->updateRules('unique:'.$permission_table.',name,{{resourceId}}')
                ->onlyOnDetail()
                ->onlyOnForms(),

            Text::make(__('nova-permission::permissions.display_name'), function () {
                return PermissionsEnum::getDescription($this->name);
            }),

            Select::make(__('nova-permission::permissions.group'), 'group')
                  ->options(PermissionsEnum::groups()),

            Select::make(__('nova-permission::permissions.guard_name'), 'guard_name')
                  ->options($guardOptions->toArray())
                  ->rules(['required', Rule::in($guardOptions)]),

            DateTime::make(__('nova-permission::permissions.created_at'), 'created_at')
                ->exceptOnForms(),
            DateTime::make(__('nova-permission::permissions.updated_at'), 'updated_at')
                ->exceptOnForms(),

            BelongsToMany::make(Role::singularLabel(), 'roles', Role::class),
            MorphToMany::make($userResource::singularLabel(), 'users', $userResource)->searchable(),
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

    public static function getModel()
    {
        //return app(PermissionRegistrar::class)->getPermissionClass();
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
        return __('nova-permission::resources.Permission');
    }

    public static function singularLabel()
    {
        return __('nova-permission::resources.Permissions');
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
