<?php
namespace Redaxscript\Modules\LiveReload;

use Redaxscript\Module;

/**
 * live reload for css
 *
 * @since 2.2.0
 *
 * @package Redaxscript
 * @category Modules
 * @author Henry Ruhs
 */

class LiveReload extends Module
{
	/**
	 * array of the module
	 *
	 * @var array
	 */

	protected static $_moduleArray = array(
		'name' => 'Live Reload',
		'alias' => 'LiveReload',
		'author' => 'Redaxmedia',
		'description' => 'Live reload for CSS',
		'version' => '2.6.2',
		'access' => '1'
	);

	/**
	 * loaderStart
	 *
	 * @since 2.2.0
	 */

	public static function loaderStart()
	{
		global $loader_modules_styles, $loader_modules_scripts;
		$loader_modules_styles[] = 'modules/LiveReload/styles/live_reload.css';
		$loader_modules_scripts[] = 'modules/LiveReload/scripts/init.js';
		$loader_modules_scripts[] = 'modules/LiveReload/scripts/live_reload.js';
	}
}
