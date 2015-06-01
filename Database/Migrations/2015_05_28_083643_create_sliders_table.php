<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlidersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( ! Schema::hasTable('sliders'))
		{
			Schema::create('sliders', function(Blueprint $table) {
				$table->bigIncrements('id');
				$table->string('title', 150)->unique();
				$table->string('description', 255)->index();
				$table->string('slider_slug', 150)->unique()->index();	
				$table->boolean('is_active')->default(1);
				$table->string('theme', 255)->index();
				$table->string('template', 255)->index();
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
		if (Schema::hasTable('sliders'))
		{
			Schema::drop('sliders');
		}
	}
}