<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->tinyInteger('featured_count')->default(16);
            $table->tinyInteger('logo_type')->default(0);
            $table->string('logo_text')->nullable();
            $table->string('logo_color')->nullable();
            $table->string('logo_fontsize')->nullable();
            $table->string('logo_font')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            //
        });
    }
}
