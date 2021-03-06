<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSliderPermission extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		foreach (\CMS::coreModuleParts()->getModuleParts('slider') as $modulePart) 
		{
			if ($modulePart->part_key == 'Sliders') 
			{
				\CMS::permissions()->insertDefaultItemPermissions(
				                 $modulePart->part_key, 
				                 $modulePart->id, 
				                 [
					                 'admin'   => ['show', 'change-status'],
					                 'manager' => ['show', 'change-status']
				                 ]);
			}
			else
			{
				\CMS::permissions()->insertDefaultItemPermissions(
					                 $modulePart->part_key, 
					                 $modulePart->id, 
					                 [
						                 'admin'   => ['show', 'add', 'edit', 'delete'],
						                 'manager' => ['show', 'edit']
					                 ]);
			}
		} 
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		foreach (\CMS::coreModuleParts()->getModuleParts('slider') as $modulePart) 
		{
			\CMS::deleteItemPermissions($modulePart->part_key);
		}
	}
}