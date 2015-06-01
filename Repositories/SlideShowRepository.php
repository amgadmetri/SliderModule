<?php namespace App\Modules\Slider\Repositories;

use App\AbstractRepositories\AbstractRepository;

class SlideShowRepository extends AbstractRepository
{
	/**
	 * Return the model full namespace.
	 * 
	 * @return string
	 */
	protected function getModel()
	{
		return 'App\Modules\Slider\SlideShow';
	}
	
	/**
	 * Return the module relations.
	 * 
	 * @return array
	 */
	protected function getRelations()
	{
		return ['slider'];
	}

	/**
	 * Return a specified Slide Show wit translations.
	 * 
	 * @param  integer $id
	 * @return object
	 */
	public function getSlideShow($id, $language = false)
	{
		$slideShow              =  $this->find($id);
		$slideShow->description = \CMS::languageContents()->getTranslations($slideShow->id, 'slide_show', $language, 'description');

		return $slideShow;
	}

	/**
	 * Store the Slide Show and it's translations in to the storage.
	 * 
	 * @param  array $data 
	 * @return object
	 */
	public function createSlideShow($data)
	{	
		$slideShow = $this->create($data);
		\CMS::languageContents()->insertLanguageContent(['description' => $data['description']], 'slide_show', $slideShow->id);
		
		return $slideShow;
	}

	/**
	 * Store the Slide Show and it's translations in to the storage.
	 * 
	 * @param  array $data 
	 * @return object
	 */
	public function updateSlideShow($id, $data)
	{	
		$this->update($id, $data);
		\CMS::languageContents()->insertLanguageContent(['description' => $data['description']], 'slide_show', $id);

		return $this->find($id);
	}
	
	/**
	 * Change the enable of specific slide show to
	 * true.
	 * 
	 * @param  integer $id
	 * @return void
	 */
	public function enableSlideShow($id)
	{
		$this->update($id, ['status' => 'enabled']);
	}

	/**
	 * Change the active of specific slide show to
	 * false.
	 * 
	 * @param  integer $id
	 * @return void
	 */
	public function disableSlideShow($id)
	{
		$this->update($id, ['status' => 'disabled']);
	}

}
