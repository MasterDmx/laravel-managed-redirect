<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManagedRedirectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('managed_redirect', function (Blueprint $table) {
            $table->id();
            $table->string('from_url', 255)->unique();
            $table->string('to_url', 255);
            $table->smallInteger('status')->default(301);
            $table->string('mark', 255);
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
        Schema::dropIfExists('managed_redirect');
    }
}
