<?php
namespace Redaxscript\Modules\TestDummy;

use Redaxscript\Module;

/**
 * made for testing
 *
 * @since 2.6.0
 *
 * @package Redaxscript
 * @category Modules
 * @author Henry Ruhs
 */

class TestDummy extends Module
{
	/**
	 * array of the module
	 *
	 * @var array
	 */

	protected static $_moduleArray =
	[
		'name' => 'Test dummy',
		'alias' => 'TestDummy',
		'author' => 'Redaxmedia',
		'description' => 'Made for testing',
		'version' => '3.0.0'
	];

	/**
	 * render
	 *
	 * @since 2.4.0
	 *
	 * @param integer $firstNumber
	 * @param integer $secondNumber
	 *
	 * @return integer
	 */

	public static function render($firstNumber = null, $secondNumber = null)
	{
		return $firstNumber + $secondNumber;
	}
}
