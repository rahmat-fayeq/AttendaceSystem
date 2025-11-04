<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('device_id');
            $table->integer('uid')->unique(); // unique log id from device
            $table->integer('user_id'); // device user_id
            $table->unsignedBigInteger('student_id')->nullable();
            $table->tinyInteger('state');
            $table->timestamp('record_time');
            $table->tinyInteger('type');
            $table->timestamps();

            $table->foreign('device_id')->references('id')->on('devices')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
