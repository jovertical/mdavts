<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('uuid');
            $table->enum('type', ['user', 'admin', '']);
            $table->string('role')->nullable();
            $table->string('username')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->boolean('active')->default(1);
            $table->boolean('verified')->default(0);

            $table->string('voters_number')->nullable();
            $table->string('lrn')->nullable();
            $table->integer('grade_level')->nullable();
            $table->string('section')->nullable();

            $table->string('firstname')->nullable();
            $table->string('middlename')->nullable();
            $table->string('lastname')->nullable();
            $table->date('birthdate')->nullable();
            $table->enum('gender', ['male', 'female', ''])->nullable();
            $table->text('address')->nullable();
            $table->string('contact_number')->nullable();

            $table->text('path')->nullable();
            $table->text('directory')->nullable();
            $table->string('filename')->nullable();

            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->uuid('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
