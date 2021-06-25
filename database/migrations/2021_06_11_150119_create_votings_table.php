<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            //
            //投票者為id
            $table->bigInteger('sid')->unsigned();
            //book id
            $table->bigInteger('bid')->unsigned();
            //設為外來鍵: 指定關聯性
            $table->foreign('sid')->references('id')->on('users');
            $table->foreign('bid')->references('id')->on('books');
            //預設值
            $table->dateTime('voting_date')->default(now());
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('votings');
    }
}
