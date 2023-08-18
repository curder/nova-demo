<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Outl1ne\MenuBuilder\Models\Menu as BaseMenu;

/**
 * @property int $id
 * @property string $name
 */
class Menu extends BaseMenu
{
    use HasFactory;
}
