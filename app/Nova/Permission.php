<?php

namespace App\Nova;

use App\Enums\PermissionsEnum;
use App\Enums\RolesEnum;
use Illuminate\Validation\Rule;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova;
use Spatie\Permission\PermissionRegistrar;
use Vyuldashev\NovaPermission\Permission as BasePermission;
use Vyuldashev\NovaPermission\RoleBooleanGroup;

class Permission extends BasePermission
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Permission>
     */
    public static $model = \App\Models\Permission::class;

    public function fields(NovaRequest $request): array
    {
        $guardOptions = collect(config('auth.guards'))->mapWithKeys(function ($value, $key) {
            return [$key => $key];
        });

        $userResource = Nova::resourceForModel(getModelForGuard($this->guard_name ?? config('auth.defaults.guard')));

        return [
            ID::make()->sortable(),

            Text::make(__('permissions.name'), 'name')
                ->rules(['required', 'string', 'max:255'])
                ->creationRules('unique:'.config('permission.table_names.permissions'))
                ->updateRules('unique:'.config('permission.table_names.permissions').',name,{{resourceId}}')
                ->displayUsing(fn ($value) => PermissionsEnum::tryFrom($value)?->label().'('.$value.')'),

            Text::make(
                __('permissions.display_name'),
                fn () => __('permissions.display_names.'.$this->name)
            )->canSee(function () {
                return is_array(__('permissions.display_names'));
            }),

            Select::make(__('permissions.guard_name'), 'guard_name')
                ->options($guardOptions->toArray())
                ->rules(['required', Rule::in($guardOptions)]),

            DateTime::make(__('permissions.created_at'), 'created_at')
                ->displayUsing(fn ($value) => $value ? $value->format('Y-m-d H:i:s') : '')
                ->exceptOnForms(),
            DateTime::make(__('permissions.updated_at'), 'updated_at')
                ->displayUsing(fn ($value) => $value ? $value->format('Y-m-d H:i:s') : '')
                ->exceptOnForms(),

            RoleBooleanGroup::make(__('permissions.roles'), 'roles')
                ->options(function () {
                    $roleClass = app(PermissionRegistrar::class)->getRoleClass();

                    return $roleClass::all()
                        ->pluck('name', 'name')
                        ->mapWithKeys(fn ($key, $value) => [$key => RolesEnum::tryFrom($value)?->label() ?? $value]);
                }),

            MorphToMany::make($userResource::label(), 'users', $userResource)
                ->searchable()
                ->singularLabel($userResource::singularLabel()),
        ];
    }
}
