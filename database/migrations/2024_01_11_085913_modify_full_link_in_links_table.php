<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ModifyFullLinkInLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('links', function (Blueprint $table) {
            $table->text('full_link_temp')->nullable();
        });

        DB::statement('UPDATE links SET full_link_temp = full_link');

        Schema::table('links', function (Blueprint $table) {
            $table->dropIndex(['full_link']);
            $table->dropColumn('full_link');

            $table->renameColumn('full_link_temp', 'full_link');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('links', function (Blueprint $table) {
            $table->string('full_link_temp', 550)->nullable();
        });

        DB::statement('UPDATE links SET full_link_temp = full_link');

        Schema::table('links', function (Blueprint $table) {
            $table->dropColumn('full_link');

            $table->renameColumn('full_link_temp', 'full_link');

            $table->index(['full_link']);
        });
    }

}
