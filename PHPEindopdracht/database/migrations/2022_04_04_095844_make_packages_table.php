<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('status');
            $table->string('sender_name');
            $table->string('sender_adres');
            $table->string('sender_city');
            $table->string('sender_postalcode');
            $table->string('receiver_name');
            $table->string('receiver_adres');
            $table->string('receiver_city');
            $table->string('receiver_postalcode');
            $table->timestamp('pick_up_time')->nullable();
            $table->foreignId('users_id')->constrained();
            $table->foreignId('transporters_id')->nullable()->constrained();
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
        Schema::dropIfExists('packages');
    }
};
