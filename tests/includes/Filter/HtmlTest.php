<?php
namespace Redaxscript\Tests\Filter;

use Redaxscript\Filter;
use Redaxscript\Tests\TestCase;

/**
 * HtmlTest
 *
 * @since 2.2.0
 *
 * @package Redaxscript
 * @category Tests
 * @author Henry Ruhs
 */

class HtmlTest extends TestCase
{
	/**
	 * providerHtml
	 *
	 * @since 2.2.0
	 *
	 * @return array
	 */

	public function providerHtml()
	{
		return $this->getProvider('tests/provider/Filter/html.json');
	}

	/**
	 * testHtml
	 *
	 * @since 2.2.0
	 *
	 * @param string $html
	 * @param string $expect
	 *
	 * @dataProvider providerHtml
	 */

	public function testHtml($html = null, $expect = null)
	{
		/* setup */

		$filter = new Filter\Html();

		/* actual */

		$actual = $filter->sanitize($html);

		/* compare */

		$this->assertEquals($expect, $actual);
	}
}
