<?php
namespace Redaxscript\Modules\Editor;

use Redaxscript\Module;

/**
 * javascript powered wysiwyg editor
 *
 * @since 2.2.0
 *
 * @package Redaxscript
 * @category Modules
 * @author Henry Ruhs
 */

class Editor extends Module
{
	/**
	 * array of the module
	 *
	 * @var array
	 */

	protected static $_moduleArray = array(
		'name' => 'Editor',
		'alias' => 'Editor',
		'author' => 'Redaxmedia',
		'description' => 'Javascript powered WYSIWYG editor',
		'version' => '2.6.0'
	);

	/**
	 * loaderStart
	 *
	 * @since 2.2.0
	 */

	public static function loaderStart()
	{
		global $loader_modules_styles, $loader_modules_scripts;
		$loader_modules_styles[] = 'modules/Editor/styles/editor.css';
		$loader_modules_scripts[] = 'modules/Editor/scripts/init.js';
		$loader_modules_scripts[] = 'modules/Editor/scripts/editor.js';
	}
}
