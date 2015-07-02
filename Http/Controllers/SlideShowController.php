<?php namespace App\Modules\Slider\Http\Controllers;

use App\Modules\Core\Http\Controllers\BaseController;
use App\Modules\Slider\Http\Requests\SlideShowFormRequest;
use Illuminate\Http\Request;

class SlideShowController extends BaseController {

	/**
	 * Specify a list of extra permissions.
	 * 
	 * @var permissions
	 */
	protected $permissions = [
	'getEnable'  => 'edit', 
	'getDisable' => 'edit' , 
	'getShow'    => 'show',
	];

	/**
	 * Create new SlideShowController instance.
	 */
	public function __construct()
	{
		parent::__construct('SlideShows');
	}

	/**
 	 * Display a listing of the slide shows.
 	 * 
 	 * @param  string $sliderSlug
 	 * @return response
 	 */
	public function getShow($sliderSlug)
	{	
		$slideShows = \CMS::sliders()->getSlideShows($sliderSlug, 'all');
		return view('slider::slideshow.slideshow', compact('slideShows', 'sliderSlug'));
	}

	/**
	 * Show the form for creating a new slide show.
	 * 
 	 * @param  string $sliderSlug
	 * @return Response
	 */
	public function getCreate($sliderSlug)
	{
		$slider                  = \CMS::sliders()->first('slider_slug', $sliderSlug);
		$links                   = \CMS::menu()->getLinks();
		$maxDisplayOrder         = \CMS::slideShows()->model->max('display_order');
		$sliderImageMediaLibrary = \CMS::galleries()->getMediaLibrary('photo', true, 'sliderImageMediaLibrary');

		return view('slider::slideshow.createslideshow', compact('slider', 'sliderImageMediaLibrary', 'maxDisplayOrder', 'links'));
	}

	/**
	 * Add a newly slide show in slide shows.
	 * 
	 * @param  SlideShowFormRequest  $request
	 * @return Response
	 */
	public function postCreate(SlideShowFormRequest $request)
	{
		$data['user_id'] = \Auth::user()->id;
		$data['link']    = strlen(trim($request->link)) ? $request->link : "#";
		$data['link']    = realpath($data['link']) && $data['link'] !== '/' ? $data['link'] : url($data['link']);
		\CMS::slideShows()->createSlideShow(array_merge($request->except('link'), $data));

		return redirect()->back()->with('message', 'Slide successfully added');
	}

	/**
	 * Show the form for editing the specified menu item.
	 * 
	 * @param  integer $id
 	 * @param  string  $sliderSlug
	 * @return Response
	 */
	public function getEdit($id, $sliderSlug)
	{
		$slider                  = \CMS::sliders()->first('slider_slug', $sliderSlug);
		$links                   = \CMS::menu()->getLinks();
		$slideShow               = \CMS::slideShows()->getSlideShow($id);
		$sliderImageMediaLibrary = \CMS::galleries()->getMediaLibrary('photo', true, 'sliderImageMediaLibrary', 'links');

		return view('slider::slideshow.editslideshow', compact('slideShow', 'slider', 'sliderImageMediaLibrary'));
	}

	/**
	 * Update the specified slide in storage.
	 * 
	 * @param  integer               $id
	 * @param  SlideShowFormRequest  $request
	 * @return Response
	 */
	public function postEdit(SlideShowFormRequest $request, $id)
	{
		$data['link'] = strlen(trim($request->link)) ? $request->link : "#";
		$data['link'] = realpath($data['link']) && $data['link'] !== '/' ? $data['link'] : url($data['link']);
		\CMS::slideShows()->updateSlideShow($id, array_merge($request->except('link'), $data));

		return redirect()->back()->with('message', 'Slide successfully updated');
	}
	
	/**
	 * Remove the specified slide show from storage.
	 * 
	 * @param  integer  $id
	 * @return Response
	 */
	public function getDelete($id)
	{
		\CMS::slideShows()->delete($id);
		return redirect()->back()->with('message', 'Slide show Deleted succssefully');
	}

	/**
	 * Enable specified slide show.
	 * 
	 * @param  integer $id
	 * @return response
	 */
	public function getEnable($id)
	{
		\CMS::slideShows()->enableSlideShow($id);
		return redirect()->back();
	}

	/**
	 * Disable specified slide show.
	 * 
	 * @param  integer $id
	 * @return response
	 */
	public function getDisable($id)
	{
		\CMS::slideShows()->disableSlideShow($id);
		return redirect()->back();
	}

	/**
	 * Return a gallery array from the given ids,
	 * handle the ajax request for inserting galleries
	 * to the slide show.
	 * 
	 * @param  Request $request
	 * @return collection
	 */
	public function getSlideshowgalleries(Request $request)
	{
		return \CMS::galleries()->getGalleries($request->input('ids'));
	}

}