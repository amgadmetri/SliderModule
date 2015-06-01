<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlideShowsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( ! Schema::hasTable('slide_shows'))
		{
			Schema::create('slide_shows', function(Blueprint $table) {
				$table->bigIncrements('id');
				$table->bigInteger('slider_id')->unsigned();
				$table->foreign('slider_id')->references('id')->on('sliders');
				$table->bigInteger('image_id');
				$table->string('link', 150)->default('#')->index();
				$table->enum('status', ['enabled', 'disabled'])->default('enabled');
				$table->bigInteger('display_order')->unsigned();
				$table->bigInteger('user_id')->unsigned();
				$table->foreign('user_id')->references('id')->on('users');
				$table->timestamps();
			});

		} 
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		if (Schema::hasTable('slide_shows'))
		{
			Schema::drop('slide_shows');
		} 
	}
}