<?php

namespace Curder\NovaPermission;

use Curder\NovaPermission\Resources\Permission;
use Curder\NovaPermission\Resources\Role;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class NovaPermissionTool extends Tool
{
    public $roleResource = Role::class;
    public $permissionResource = Permission::class;

    /**
     * Perform any tasks that need to happen when the tool is booted.
     */
    public function boot()
    {
        // Nova::style('nova-permission', __DIR__.'/../dist/css/tool.css');
        Nova::script('nova-permission', __DIR__.'/../dist/js/tool.js');
        Nova::resources([
            $this->roleResource,
            $this->permissionResource,
        ]);
    }

    public function roleResource(string $roleResource)
    {
        $this->roleResource = $roleResource;

        return $this;
    }

    public function permissionResource(string $permissionResource)
    {
        $this->permissionResource = $permissionResource;

        return $this;
    }
}
