<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElectionControlNumbers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('election_control_numbers', function (Blueprint $table) {
            $table->uuid('election_uuid')->index();
            $table->uuid('voter_uuid')->index();
            $table->string('number');
            $table->boolean('used')->default(0);
            $table->timestamp('used_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('election_control_numbers');
    }
}
