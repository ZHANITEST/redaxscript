<?php
namespace Redaxscript\Modules\Maps;

use Redaxscript\Html;
use Redaxscript\Registry;

/**
 * integrate social buttons
 *
 * @since 2.2.0
 *
 * @package Redaxscript
 * @category Modules
 * @author Henry Ruhs
 */

class Maps extends Config
{
	/**
	 * array of the module
	 *
	 * @var array
	 */

	protected static $_moduleArray = array(
		'name' => 'Maps',
		'alias' => 'Maps',
		'author' => 'Redaxmedia',
		'description' => 'Integrate Google Maps',
		'version' => '2.6.0'
	);

	/**
	 * loaderStart
	 *
	 * @since 2.2.0
	 */

	public static function loaderStart()
	{
		if (!Registry::get('adminParameter'))
		{
			global $loader_modules_styles, $loader_modules_scripts;
			$loader_modules_styles[] = 'modules/Maps/styles/maps.css';
			$loader_modules_scripts[] = 'modules/Maps/scripts/init.js';
			$loader_modules_scripts[] = 'modules/Maps/scripts/maps.js';
		}
	}

	/**
	 * scriptEnd
	 *
	 * @since 2.2.0
	 */

	public static function scriptEnd()
	{
		if (!Registry::get('adminParameter'))
		{
			$output = '<script src="' . self::$_config['apiUrl'] . '?key=' . self::$_config['apiKey'] . '&amp;sensor=' . self::$_config['sensor'] . '"></script>';
			echo $output;
		}
	}

	/**
	 * render
	 *
	 * @since 2.2.0
	 *
	 * @param integer $lat
	 * @param integer $lng
	 * @param integer $zoom
	 *
	 * @return string
	 */

	public static function render($lat = 0, $lng = 0, $zoom = 0)
	{
		$mapElement = new Html\Element('div', array(
			'class' => self::$_config['className']
		));

		/* collect attributes */

		if (is_numeric($lat))
		{
			$mapElement->attr('data-lat', $lat);
		}
		if (is_numeric($lng))
		{
			$mapElement->attr('data-lng', $lng);
		}
		if (is_numeric($zoom))
		{
			$mapElement->attr('data-zoom', $zoom);
		}
		$output = $mapElement;
		return $output;
	}
}
