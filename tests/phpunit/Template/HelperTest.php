<?php
namespace Redaxscript\Tests\Template;

use Redaxscript\Db;
use Redaxscript\Registry;
use Redaxscript\Template;
use Redaxscript\Tests\TestCaseAbstract;

/**
 * HelperTest
 *
 * @since 3.0.0
 *
 * @package Redaxscript
 * @category Tests
 * @author Henry Ruhs
 * @author Balázs Szilágyi
 */

class HelperTest extends TestCaseAbstract
{
	/**
	 * instance of the registry class
	 *
	 * @var object
	 */

	protected $_registry;

	/**
	 * setUp
	 *
	 * @since 3.0.0
	 */

	public function setUp()
	{
		$this->_registry = Registry::getInstance();
	}

	/**
	 * setUpBeforeClass
	 *
	 * @since 3.0.0
	 */

	public static function setUpBeforeClass()
	{
		Db::forTablePrefix('articles')
			->create()
			->set(
			[
				'id' => 2,
				'title' => 'test',
				'alias' => 'test-one',
				'author' => 'test',
				'description' => 'article-description',
				'keywords' => 'article-keywords',
				'robots' => 4,
				'text' => 'test',
				'category' => 1
			])
			->save();
		Db::forTablePrefix('categories')
			->create()
			->set(
			[
				'id' => 2,
				'title' => 'test',
				'alias' => 'test-two',
				'description' => 'category-description',
				'keywords' => 'category-keywords',
				'robots' => 1,
				'parent' => 0
			])
			->save();
	}

	/**
	 * tearDownAfterClass
	 *
	 * @since 3.0.0
	 */

	public static function tearDownAfterClass()
	{
		Db::forTablePrefix('articles')->where('alias', 'test-one')->deleteMany();
		Db::forTablePrefix('categories')->where('alias', 'test-two')->deleteMany();
	}

	/**
	 * providerCanonical
	 *
	 * @since 3.0.0
	 *
	 * @return array
	 */

	public function providerCanonical()
	{
		return $this->getProvider('tests/provider/Template/helper_canonical.json');
	}

	/**
	 * providerDescription
	 *
	 * @since 3.0.0
	 *
	 * @return array
	 */

	public function providerDescription()
	{
		return $this->getProvider('tests/provider/Template/helper_description.json');
	}

	/**
	 * providerKeywords
	 *
	 * @since 3.0.0
	 *
	 * @return array
	 */

	public function providerKeywords()
	{
		return $this->getProvider('tests/provider/Template/helper_keywords.json');
	}

	/**
	 * providerRobots
	 *
	 * @since 3.0.0
	 *
	 * @return array
	 */

	public function providerRobots()
	{
		return $this->getProvider('tests/provider/Template/helper_robots.json');
	}

	/**
	 * providerGetSubset
	 *
	 * @since 3.0.0
	 *
	 * @return array
	 */

	public function providerGetSubset()
	{
		return $this->getProvider('tests/provider/Template/helper_get_subset.json');
	}

	/**
	 * providerGetDirection
	 *
	 * @since 3.0.0
	 *
	 * @return array
	 */

	public function providerGetDirection()
	{
		return $this->getProvider('tests/provider/Template/helper_get_direction.json');
	}

	/**
	 * providerGetDirection
	 *
	 * @since 3.0.0
	 *
	 * @return array
	 */

	public function providerGetClass()
	{
		return $this->getProvider('tests/provider/Template/helper_get_class.json');
	}

	/**
	 * testCanonical
	 *
	 * @since 3.0.0
	 *
	 * @param array $registryArray
	 * @param string $expect
	 *
	 * @dataProvider providerCanonical
	 */

	public function testCanonical($registryArray = [], $expect = null)
	{
		/* setup */

		$this->_registry->init($registryArray);

		/* actual */

		$actual = Template\Helper::getCanonical();

		/* compare */

		$this->assertEquals($expect, $actual);
	}

	/**
	 * testDescription
	 *
	 * @since 3.0.0
	 *
	 * @param array $registryArray
	 * @param string $expect
	 *
	 * @dataProvider providerDescription
	 */

	public function testDescription($registryArray = [], $expect = null)
	{
		/* setup */

		$this->_registry->init($registryArray);

		/* actual */

		$actual = Template\Helper::getDescription();

		/* compare */

		$this->assertEquals($expect, $actual);
	}

	/**
	 * testKeywords
	 *
	 * @since 3.0.0
	 *
	 * @param array $registryArray
	 * @param string $expect
	 *
	 * @dataProvider providerKeywords
	 */

	public function testKeywords($registryArray = [], $expect = null)
	{
		/* setup */

		$this->_registry->init($registryArray);

		/* actual */

		$actual = Template\Helper::getKeywords();

		/* compare */

		$this->assertEquals($expect, $actual);
	}

	/**
	 * testRobots
	 *
	 * @since 3.0.0
	 *
	 * @param array $registryArray
	 * @param string $expect
	 *
	 * @dataProvider providerRobots
	 */

	public function testRobots($registryArray = [], $expect = null)
	{
		/* setup */

		$this->_registry->init($registryArray);

		/* actual */

		$actual = Template\Helper::getRobots();

		/* compare */

		$this->assertEquals($expect, $actual);
	}

	/**
	 * testGetSubset
	 *
	 * @since 3.0.0
	 *
	 * @param array $registryArray
	 * @param string $expect
	 *
	 * @dataProvider providerGetSubset
	 */

	public function testGetSubset($registryArray = [], $expect = null)
	{
		/* setup */

		$this->_registry->init($registryArray);

		/* actual */

		$actual = Template\Helper::getSubset();

		/* compare */

		$this->assertEquals($expect, $actual);
	}

	/**
	 * testGetDirection
	 *
	 * @since 3.0.0
	 *
	 * @param array $registryArray
	 * @param string $expect
	 *
	 * @dataProvider providerGetDirection
	 */

	public function testGetDirection($registryArray = [], $expect = null)
	{
		/* setup */

		$this->_registry->init($registryArray);

		/* actual */

		$actual = Template\Helper::getDirection();

		/* compare */

		$this->assertEquals($expect, $actual);
	}

	/**
	 * testGetClass
	 *
	 * @since 3.0.0
	 *
	 * @param array $registryArray
	 * @param string $expect
	 *
	 * @dataProvider providerGetClass
	 */

	public function testGetClass($registryArray = [], $expect = null)
	{
		/* setup */

		$this->_registry->init($registryArray);

		/* actual */

		$actual = Template\Helper::getClass();

		/* compare */

		$this->assertEquals($expect, $actual);
	}
}
