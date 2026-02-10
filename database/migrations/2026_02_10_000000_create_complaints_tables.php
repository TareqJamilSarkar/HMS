<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplaintsTables extends Migration
{
    public function up()
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('room_id')->index();
            $table->unsignedBigInteger('room_type_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable(); // user/admin id
            $table->enum('status', ['open', 'resolved', 'in_progress'])->default('open');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });

        Schema::create('complaint_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('complaint_id')->index();
            $table->string('title'); // e.g. "AC not working"
            $table->text('details')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('complaint_items');
        Schema::dropIfExists('complaints');
    }
}
