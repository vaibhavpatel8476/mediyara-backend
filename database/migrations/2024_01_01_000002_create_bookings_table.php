<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('registration_id')->unique();
            $table->string('patient_name');
            $table->string('patient_email');
            $table->string('patient_phone');
            $table->unsignedTinyInteger('patient_age')->nullable();
            $table->string('patient_gender')->nullable();
            $table->string('test_type');
            $table->string('collection_type');
            $table->date('preferred_date');
            $table->string('preferred_time');
            $table->string('address')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
