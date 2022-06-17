<?php

namespace App\Nova;

class Role extends \Vyuldashev\NovaPermission\Role
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Role::class;
}
