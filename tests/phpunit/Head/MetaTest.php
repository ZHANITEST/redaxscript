<?php
namespace Redaxscript\Tests\Head;

use Redaxscript\Head;
use Redaxscript\Tests\TestCaseAbstract;

/**
 * MetaTest
 *
 * @since 3.0.0
 *
 * @package Redaxscript
 * @category Tests
 * @author Henry Ruhs
 * @author Balázs Szilágyi
 */

class MetaTest extends TestCaseAbstract
{
	/**
	 * providerAppend
	 *
	 * @since 3.0.0
	 *
	 * @return array
	 */

	public function providerAppend()
	{
		return $this->getProvider('tests/provider/Head/meta_append.json');
	}

	/**
	 * testAppend
	 *
	 * @since 3.0.0
	 *
	 * @dataProvider providerAppend
	 *
	 * @param array $metaArray
	 * @param string $expect
	 */

	public function testAppend($metaArray = [], $expect = null)
	{
		/* setup */

		$meta = Head\Meta::getInstance();
		$meta->init('append');
		foreach ($metaArray as $value)
		{
			$meta->append($value);
		}

		/* actual */

		$actual = $meta;

		/* compare */

		$this->assertEquals($this->normalizeEOL($expect), $actual);
	}
}
