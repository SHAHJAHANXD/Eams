<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeyStorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('key_storks', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('clicked_on')->nullable();
            $table->string('clicked_link')->nullable();
            $table->string('Key_storking')->nullable();
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
        Schema::dropIfExists('key_storks');
    }
}
