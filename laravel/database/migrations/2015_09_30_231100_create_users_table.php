<?php

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
        Schema::create('User', function (Blueprint $table) {
            $table->increments('idUSER');
            $table->string('lastNameUSER', 50);
			$table->string('firstNameUSER', 50);
			$table->string('codeUSER', 7);
			$table->boolean('isManagerUSER');
        });
		
		Schema::create('Book', function (Blueprint $table){
			$table->increments('idBOOK');
			$table->string('titleBOOK', 100);
			$table->string('authorBOOK', 100);
		});
		
		Schema::create('User_Book', function (Blueprint $table){
			$table->integer('idUSER');
			$table->integer('idBOOK');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('User');
    }
}
