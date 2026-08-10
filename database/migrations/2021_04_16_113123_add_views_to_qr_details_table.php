<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddViewsToQrDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('qr_details', function (Blueprint $table) {
            $table->integer('page_views')->after('call_service_expire_at')->default(0)->unsigned();
            $table->integer('call_impressions')->after('page_views')->default(0)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('qr_details', function (Blueprint $table) {
            $table->dropColumn('page_views');
            $table->dropColumn('call_impressions');
        });
    }
}
