<?php

namespace App\Models;

use Outl1ne\MenuBuilder\Models\Menu as BaseMenu;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $name
 */
class Menu extends BaseMenu
{
    use HasFactory;
}
