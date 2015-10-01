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
        Schema::create('Users', function (Blueprint $table) {
            $table->increments('idUSERS');
            $table->string('lastNameUSERS', 50);
			$table->string('firstNameUSERS', 50);
			$table->string('codeUSERS', 7);
			$table->boolean('isManagerUSERS');
        });
		
		Schema::create('Book', function (Blueprint $table){
			$table->increments('idBOOK');
			$table->string('titleBOOK', 100);
			$table->string('authorBOOK', 100);
		});
		
		Schema::create('User_Book', function (Blueprint $table){
			$table->integer('idUSERS');
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
