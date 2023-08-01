<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Outl1ne\MenuBuilder\MenuBuilder;

class CreateNestableFieldToMenusTable extends Migration
{
    public function up()
    {
        if (! Schema::hasColumn(MenuBuilder::getMenuItemsTableName(), 'nestable')) {
            Schema::table(MenuBuilder::getMenuItemsTableName(), function (Blueprint $table) {
                $table->boolean('nestable')->default(1);
            });
        }
    }

    public function down()
    {
        Schema::dropColumns(MenuBuilder::getMenuItemsTableName(), ['nestable']);
    }
}
