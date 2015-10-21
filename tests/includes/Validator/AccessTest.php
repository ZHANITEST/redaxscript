<?php
namespace Redaxscript\Tests\Validator;

use Redaxscript\Tests\TestCase;
use Redaxscript\Validator;

/**
 * AccessTest
 *
 * @since 2.2.0
 *
 * @package Redaxscript
 * @category Tests
 * @author Henry Ruhs
 * @author Sven Weingartner
 */

class AccessTest extends TestCase
{
	/**
	 * providerAccess
	 *
	 * @since 2.2.0
	 *
	 * @return array
	 */

	public function providerAccess()
	{
		return $this->getProvider('tests/provider/Validator/access.json');
	}

	/**
	 * testAccess
	 *
	 * @since 2.2.0
	 *
	 * @param string $access
	 * @param string $groups
	 * @param integer $expect
	 *
	 * @dataProvider providerAccess
	 */

	public function testAccess($access = null, $groups = null, $expect = null)
	{
		/* setup */

		$validator = new Validator\Access();

		/* actual */

		$actual = $validator->validate($access, $groups);

		/* compare */

		$this->assertEquals($expect, $actual);
	}
}
