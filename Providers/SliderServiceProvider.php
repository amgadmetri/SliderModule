<?php
namespace App\Modules\Slider\Providers;

use App;
use Config;
use Lang;
use View;
use Illuminate\Support\ServiceProvider;

class SliderServiceProvider extends ServiceProvider
{
	/**
	 * Register the Slider module service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// This service provider is a convenient place to register your modules
		// services in the IoC container. If you wish, you may make additional
		// methods or service providers to keep the code more focused and granular.
		App::register('App\Modules\Slider\Providers\RouteServiceProvider');

		$this->registerNamespaces();
	}

	/**
	 * Register the Slider module resource namespaces.
	 *
	 * @return void
	 */
	protected function registerNamespaces()
	{
		Lang::addNamespace('slider', realpath(__DIR__.'/../Resources/Lang'));

		View::addNamespace('slider', realpath(__DIR__.'/../Resources/Views'));
	}
}
