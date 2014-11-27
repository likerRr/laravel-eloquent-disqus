<?php namespace Alizurchik\EloquentDisqus\Facades;

use Illuminate\Support\Facades\Facade;

class EloquentDisqus extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() {
		return 'eloquent.disqus';
	}
}