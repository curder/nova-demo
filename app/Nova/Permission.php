<?php

namespace App\Nova;

use App\Enums;
use App\Models;
use Illuminate\Validation\Rule;
use Laravel\Nova\Fields;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova;
use Spatie\Permission\PermissionRegistrar;
use Vyuldashev\NovaPermission;

class Permission extends NovaPermission\Permission
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<Models\Permission>
     */
    public static $model = Models\Permission::class;

    public function fields(NovaRequest $request): array
    {
        $guardOptions = collect(config('auth.guards'))->mapWithKeys(function ($value, $key) {
            return [$key => $key];
        });

        /** @var User $userResource */
        $userResource = Nova::resourceForModel(getModelForGuard($this->guard_name ?? config('auth.defaults.guard')));

        return [
            Fields\ID::make()->sortable(),

            Fields\Text::make(__('permissions.name'), 'name')
                ->rules(['required', 'string', 'max:255'])
                ->creationRules('unique:'.config('permission.table_names.permissions'))
                ->updateRules('unique:'.config('permission.table_names.permissions').',name,{{resourceId}}')
                ->displayUsing(fn ($value) => Enums\Permission::tryFrom($value)?->label().'('.$value.')'),

            Fields\Select::make(__('permissions.guard_name'), 'guard_name')
                ->options($guardOptions->toArray())
                ->rules(['required', Rule::in($guardOptions)]),

            Fields\DateTime::make(__('permissions.created_at'), 'created_at')
                ->displayUsing(fn ($value) => $value ? $value->format('Y-m-d H:i:s') : '')
                ->exceptOnForms(),
            Fields\DateTime::make(__('permissions.updated_at'), 'updated_at')
                ->displayUsing(fn ($value) => $value ? $value->format('Y-m-d H:i:s') : '')
                ->exceptOnForms(),

            NovaPermission\RoleBooleanGroup::make(__('permissions.roles'), 'roles')
                ->options(fn () => (app(PermissionRegistrar::class)->getRoleClass())::all()
                    ->pluck('name', 'name')
                    ->mapWithKeys(fn ($key, $value) => [$key => Enums\Role::tryFrom($value)?->label() ?? $value])),

            Fields\MorphToMany::make($userResource::label(), 'users', $userResource)
                ->searchable()
                ->singularLabel($userResource::singularLabel()),
        ];
    }
}
