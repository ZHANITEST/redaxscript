<?php
namespace Redaxscript\Modules\Disqus;

use Redaxscript\Registry;

/**
 * replace comments with disqus
 *
 * @since 2.2.0
 *
 * @package Redaxscript
 * @category Modules
 * @author Henry Ruhs
 */

class Disqus extends Config
{
	 /**
	  * custom module setup
	  *
	  * @var array
	  */

	 protected static $_module = array(
	 	 'name' => 'Disqus',
	 	 'alias' => 'Disqus',
	 	 'author' => 'Redaxmedia',
	 	 'description' => 'Replace comments with disqus',
	 	 'version' => '2.2.0',
	 	 'status' => 1,
	 	 'access' => 0
	 );

	 /**
	  * loaderStart
	  *
	  * @since 2.2.0
	  */

	 public static function loaderStart()
	 {
	 	 if (Registry::get('article'))
	 	 {
	 	 	 global $loader_modules_scripts;
	 	 	 $loader_modules_scripts[] = 'modules/disqus/scripts/startup.js';
	 	 }
	 }

	 /**
	  * renderStart
	  *
	  * @since 2.2.0
	  */

	 public static function renderStart()
	 {
	 	 if (Registry::get('article'))
	 	 {
	 	 	 Registry::set('commentReplace', 1);
	 	 }
	 }

	 /**
	  * commentsReplace
	  *
	  * @since 2.2.0
	  */

	 public static function commentsReplace()
	 {
	 	 $output = DISQUS_TARGET . PHP_EOL;
	 	 $output .= '<script src="' . DISQUS_EMBED_URL . '"></script>' . PHP_EOL;
	 	 echo $output;
	 }
}