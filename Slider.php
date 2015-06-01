<?php namespace App\Modules\Slider;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model {

	/**
	 * Spescify the storage table.
	 * 
	 * @var table
	 */
	protected $table    = 'sliders';

	/**
	 * Specify the fields allowed for the mass assignment.
	 * 
	 * @var fillable
	 */
	protected $fillable = ['title', 'slider_slug', 'description', 'is_active'];

	/**
	 * Get the slider slideShow.
	 * 
	 * @return collection
	 */
	public function slideShows()
	{
		return $this->hasMany('App\Modules\Slider\SlideShow', 'slider_id');
	}
	
	public static function boot()
	{
		parent::boot();

		/**
		 * Remove the slide shows related to 
		 * the deleted slider.
		 */
		Slider::deleting(function($slider)
		{
			$slider->slideShows()->delete();
		});
	}
}
