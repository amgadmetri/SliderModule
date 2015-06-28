<?php namespace App\Modules\Slider\Http\Controllers;

use App\Modules\Core\Http\Controllers\BaseController;

class SliderController extends BaseController {

	/**
	 * Specify a list of extra permissions.
	 * 
	 * @var permissions
	 */
	protected $permissions = [
	'getActivate'   => 'change-status', 
	'getDeactivate' => 'change-status' , 
	];

	/**
	 * Create new SliderController instance.
	 */
	public function __construct()
	{
		parent::__construct('Sliders');
	}

	/**
 	 * Display a listing of the menus.
 	 * 
 	 * @return response
 	 */
	public function getIndex()
	{
		$sliders = \CMS::sliders()->getAllSliders();
		return view('slider::slider.slider', compact('sliders'));
	}

	/**
	 * Active specified slider.
	 * 
	 * @param  integer $id
	 * @return response
	 */
	public function getActivate($id)
	{
		\CMS::sliders()->activateSlider($id);
		return redirect()->back();
	}

	/**
	 * Deactive specified slider.
	 * 
	 * @param  integer $id
	 * @return response
	 */

	public function getDeactivate($id)
	{
		\CMS::sliders()->deactivateSlider($id);
		return redirect()->back();
	}
}