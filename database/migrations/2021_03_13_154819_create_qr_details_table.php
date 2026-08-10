<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQrDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qr_details', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('qr_code_id')->nullable();
            $table->text('message')->default('Hello, In case of any any emergency please contact my mobile number.');
            $table->string('blood_group')->nullable();
            $table->string('emergency_phone')->nullable();
            $table->timestamp('emergency_phone_verified_at')->nullable();
            $table->string('is_emergency_phone_hidden')->default('1');
            $table->string('status')->default('Active');
            $table->timestamp('call_service_expire_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qr_details');
    }
}
