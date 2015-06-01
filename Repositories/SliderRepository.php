<?php namespace App\Modules\Slider\Repositories;

use App\AbstractRepositories\AbstractRepository;

class SliderRepository extends AbstractRepository
{
	/**
	 * Return the model full namespace.
	 * 
	 * @return string
	 */
	protected function getModel()
	{
		return 'App\Modules\Slider\Slider';
	}
	
	/**
	 * Return the module relations.
	 * 
	 * @return array
	 */
	protected function getRelations()
	{
		return ['slideShows'];
	}
	
	/**
	 * Get all sliders based on the given theme.
	 * If the theme isn't given then get the default
	 * theme.
	 * 
	 * @param  string $theme
	 * @return collection
	 */
	public function getAllSliders($theme = false)
	{
		$theme = $theme ?: \CMS::coreModules()->getActiveTheme()->module_key;
		return $this->findBy('theme', $theme);
	}

	/**
	 * Return slide show belongs to specific
	 * slider ordered by display_order.
	 * 
	 * @param  string $sliderSlug
	 * @param  string $status
	 * @param  string $language
	 * @return collection
	 */
	public function getSlideShows($sliderSlug, $status = 'published', $language = false)
	{
		if ($status == 'all') 
		{
			$slideShows = $this->first('slider_slug', $sliderSlug)->slideShows()->orderBy('display_order')->get();
		}
		else
		{
			$slideShows = $this->first('slider_slug', $sliderSlug)->slideShows()->
			                     where('status' ,'enabled')->orderBy('display_order')->get();
		}
		return $this->getSliderTranslations($slideShows, $language);
	}

	/**
	 * Return the slide shows translated data 
	 * based on the given language.
	 * 
	 * @param  collection $slideShows
	 * @param  string     $language
	 * @return collection
	 */
	public function getSliderTranslations($slideShows, $language)
	{
		foreach ($slideShows as $slideShow) 
		{
			$slideShow->description = \CMS::languageContents()->getTranslations($slideShow->id, 'slide_show', $language, 'description');
		}
		return $slideShows;
	}

	/**
	 * Return the slide shows based on the given slider 
	 * and language.
	 * 
	 * @param  string $sliderName
	 * @param  string $language
	 * @param  string $path
	 * @return string
	 */
	public function renderSlider($sliderSlug, $language = false, $path = false)
	{
		if ($this->checkSlider($sliderSlug))
		{
			$slider        = $this->first('slider_slug', $sliderSlug);
			$slideShows    = $this->getSlideShows($sliderSlug, $language);
			$themeName     = \CMS::CoreModules()->getActiveTheme()->module_key ;
			$specifiedPath = $themeName . "::" . $path . "." . $slider->template;
			$defaultPath   = $themeName . "::templates.sliders." . $slider->template;

			if ($path && view()->exists($specifiedPath))
			{
				return view($specifiedPath, compact('slideShows'))->render();
			}
			elseif(view()->exists($defaultPath))
			{
				return view($defaultPath, compact('slideShows'))->render();
			}
		}
		return '';
	}

	/**
	 * Change the active of specific slider to
	 * true.
	 * 
	 * @param  integer $id
	 * @return void
	 */
	public function activateSlider($id)
	{
		$this->update($id, ['is_active' => 1]);
	}

	/**
	 * Change the active of specific slider to
	 * false.
	 * 
	 * @param  integer $id
	 * @return void
	 */
	public function deactivateSlider($id)
	{
		$this->update($id, ['is_active' => 0]);
	}

	/**
	 * Check if the slider with the given slider slug
	 * is active or not.
	 * 
	 * @param  string $sliderSlug
	 * @return boolean
	 */
	public function checkSlider($sliderSlug)
	{	
		$slider = $this->model->where('slider_slug', '=', $sliderSlug)->first();
		return $slider ? $slider->is_active : false;
	}
}
