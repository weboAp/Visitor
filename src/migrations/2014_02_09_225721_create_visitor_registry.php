<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitorRegistry extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('visitor_registry', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('ip', 32);
			$table->text('geo')->nullable();
			$table->integer('counter')->unsigned()->default( 0 );
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
		Schema::drop('visitor_registry');
	}

}
