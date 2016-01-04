<?php
namespace Redaxscript\Modules\GetFile;

use Redaxscript\Db;
use Redaxscript\Module;

/**
 * file information helper
 *
 * @since 2.2.0
 *
 * @package Redaxscript
 * @category Modules
 * @author Henry Ruhs
 */

class GetFile extends Module
{
	/**
	 * array of the module
	 *
	 * @var array
	 */

	protected static $_moduleArray = array(
		'name' => 'Get file',
		'alias' => 'GetFile',
		'author' => 'Redaxmedia',
		'description' => 'File information helper',
		'version' => '2.6.2'
	);

	/**
	 * render
	 *
	 * @since 2.2.0
	 *
	 * @param string $file
	 * @param string $type
	 * @param string $unit
	 *
	 * @return string
	 */

	public static function render($file = null, $type = 'size', $unit = 'kb')
	{
		$output = null;

		/* size */

		if ($type === 'size')
		{
			$output = filesize($file);

			/* calculate output */

			if ($unit === 'kb' || $unit === 'mb')
			{
				$output /= 1024;
			}
			if ($unit === 'mb')
			{
				$output /= 1024;
			}
			$output = ceil($output);
		}

		/* date */

		if ($type === 'date')
		{
			$output = date(Db::getSettings('date'), filectime($file));
		}
		return $output;
	}
}
