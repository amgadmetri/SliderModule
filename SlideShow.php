<?php namespace App\Modules\Slider;

use Illuminate\Database\Eloquent\Model;

class SlideShow extends Model {

	/**
	 * Spescify the storage table.
	 * 
	 * @var table
	 */
	protected $table    = 'slide_shows';

	/**
	 * Specify the fields allowed for the mass assignment.
	 * 
	 * @var fillable
	 */
	protected $fillable = ['slider_id', 'image_id', 'link', 'status', 'display_order', 'user_id'];
	
	/**
     * Return the gallery object from the
     * stored gallery id of the slide show.
     * 
     * @return object
     */
    public function getSlideShowImageAttribute()
    {
        return \CMS::galleries()->find($this->attributes['image_id']);
    }

	/**
	 * Get the slideShow slider.
	 * 
	 * @return object
	 */
	public function slider()
	{
		return $this->belongsTo('App\Modules\Slider\Slider');
	}

	public static function boot()
	{
		parent::boot();

		/**
		 * Remove the translations related 
		 * to the deleted slide show.
		 */
		SlideShow::deleting(function($slideShow)
		{
			\CMS::languageContents()->deleteItemLanguageContents('slide_show', $slideShow->id);
		});
	}
}
