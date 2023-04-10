<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title',250)->nullable(false);
            $table->string('description')->nullable(false);
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('estimated_deadline')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->boolean('review_passed')->default(false);
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('worker_id');
            $table->unsignedBigInteger('project_id');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');
            $table->foreign('worker_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
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
        Schema::dropIfExists('tasks');
    }
}
