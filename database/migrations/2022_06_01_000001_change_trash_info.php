<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTrashInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trash_info', function (Blueprint $table) {
            $table->unsignedInteger('trash_type_index')->index()->nullable();
            $table->unsignedInteger('trash_location_index')->index()->nullable();
            $table->unsignedInteger('trash_group_index')->index()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trash_info', function (Blueprint $table) {
            $table->dropColumn('trash_type_index');
            $table->dropColumn('trash_location_index');
            $table->dropColumn('trash_group_index');
        });
    }
}
