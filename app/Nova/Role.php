<?php

namespace App\Nova;

use App\Enums\PermissionsEnum;
use App\Enums\RolesEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova;
use Spatie\Permission\PermissionRegistrar;
use Vyuldashev\NovaPermission\PermissionBooleanGroup;
use Vyuldashev\NovaPermission\Role as BaseRole;

class Role extends BaseRole
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Role>
     */
    public static $model = \App\Models\Role::class;

    public function fields(NovaRequest $request): array
    {
        $guardOptions = collect(config('auth.guards'))->mapWithKeys(function ($value, $key) {
            return [$key => $key];
        });

        $userResource = Nova::resourceForModel(getModelForGuard($this->guard_name ?? config('auth.defaults.guard')));

        return [
            ID::make()->sortable(),

            Text::make(__('roles.name'), 'name')
                ->rules(['required', 'string', 'max:255'])
                ->creationRules('unique:'.config('permission.table_names.roles'))
                ->updateRules('unique:'.config('permission.table_names.roles').',name,{{resourceId}}')
                ->displayUsing(fn ($value) => RolesEnum::tryFrom($value)?->label() ?? $value),

            Select::make(__('roles.guard_name'), 'guard_name')
                ->options($guardOptions->toArray())
                ->rules(['required', Rule::in($guardOptions)]),

            DateTime::make(__('roles.created_at'), 'created_at')
                ->displayUsing(fn ($value) => $value ? $value->format('Y-m-d H:i:s') : '')
                ->exceptOnForms(),
            DateTime::make(__('roles.updated_at'), 'updated_at')
                ->displayUsing(fn ($value) => $value ? $value->format('Y-m-d H:i:s') : '')
                ->exceptOnForms(),

            PermissionBooleanGroup::make(__('roles.permissions'), 'permissions')
                ->options(function () {
                    $permissionClass = app(PermissionRegistrar::class)->getPermissionClass();

                    return $permissionClass::all()
                        ->filter(
                            fn ($permission) => Auth::user()->can('view', $permission)
                        )->pluck('name', 'name')
                        ->mapWithKeys(fn ($key, $value) => [$key => PermissionsEnum::tryFrom($value)?->label() ?? $value]);
                }),

            MorphToMany::make($userResource::label(), 'users', $userResource)
                ->searchable()
                ->singularLabel($userResource::singularLabel()),
        ];
    }
}
