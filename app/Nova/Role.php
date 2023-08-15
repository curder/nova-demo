<?php

namespace App\Nova;

use App\Enums;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Laravel\Nova\Fields;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova;
use Spatie\Permission\PermissionRegistrar;
use Vyuldashev\NovaPermission;

class Role extends NovaPermission\Role
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Role>
     */
    public static $model = \App\Models\Role::class;

    public function fields(NovaRequest $request): array
    {
        $guardOptions = collect(config('auth.guards'))->mapWithKeys(function (string $value, string $key) {
            return [$key => $key];
        });

        /** @var User $userResource */
        $userResource = Nova::resourceForModel(getModelForGuard($this->guard_name ?? config('auth.defaults.guard')));

        return [
            Fields\ID::make()->sortable(),

            Fields\Text::make(__('roles.name'), 'name')
                ->rules(['required', 'string', 'max:255'])
                ->creationRules('unique:'.config('permission.table_names.roles'))
                ->updateRules('unique:'.config('permission.table_names.roles').',name,{{resourceId}}')
                ->displayUsing(fn (string $value) => Enums\Role::tryFrom($value)?->label() ?? $value),

            Fields\Select::make(__('roles.guard_name'), 'guard_name')
                ->options($guardOptions->toArray())
                ->rules(['required', Rule::in($guardOptions)]),

            Fields\DateTime::make(__('roles.created_at'), 'created_at')
                ->displayUsing(fn (?Carbon $value) => $value ? $value->format('Y-m-d H:i:s') : '')
                ->exceptOnForms(),
            Fields\DateTime::make(__('roles.updated_at'), 'updated_at')
                ->displayUsing(fn (?Carbon $value) => $value ? $value->format('Y-m-d H:i:s') : '')
                ->exceptOnForms(),

            NovaPermission\PermissionBooleanGroup::make(__('roles.permissions'), 'permissions')
                ->options(function () {
                    return (app(PermissionRegistrar::class)->getPermissionClass())::all()
                        ->filter(fn (string $permission) => Auth::user()->can('view', $permission))
                        ->pluck('name', 'name')
                        ->mapWithKeys(fn (string $key, string $value) => [$key => Enums\Permission::tryFrom($value)?->label() ?? $value]);
                }),

            Fields\MorphToMany::make($userResource::label(), 'users', $userResource)
                ->searchable()
                ->singularLabel($userResource::singularLabel()),
        ];
    }
}
