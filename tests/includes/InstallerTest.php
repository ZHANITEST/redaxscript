<?php
namespace Redaxscript\Tests;

use Redaxscript\Config;
use Redaxscript\Db;
use Redaxscript\Installer;

/**
 * InstallerTest
 *
 * @since 2.4.0
 *
 * @package Redaxscript
 * @category Tests
 * @author Henry Ruhs
 */

class InstallerTest extends TestCase
{
	/**
	 * instance of the config class
	 *
	 * @var object
	 */

	protected $_config;

	/**
	 * setUp
	 *
	 * @since 2.4.0
	 */

	public function setUp()
	{
		$this->_config = Config::getInstance();
		$this->_config->set('prefix', 'installer_');
		Db::clearCache();
	}

	/**
	 * tearDown
	 *
	 * @since 2.4.0
	 */

	public function tearDown()
	{
		$this->_config->set('prefix', '');
	}

	/**
	 * testCreateMysql
	 *
	 * @since 2.4.0
	 */

	public function testCreateMysql()
	{
		/* setup */

		$this->_config->set('type', 'mysql');
		$installer = new Installer();
		$installer->init($this->_config);
		$installer->create();

		/* actual */

		$actual = Db::rawInstance()->rawQuery('SHOW TABLES LIKE \'' . $this->_config->get('prefix') . '%\'')->findMany()->count();

		/* compare */

		$this->assertGreaterThan(7, $actual);
	}

	/**
	 * testInsertMysql
	 *
	 * @since 2.4.0
	 */

	public function testInsertMysql()
	{
		/* setup */

		$this->_config->set('type', 'mysql');
		$installer = new Installer();
		$installer->init($this->_config);
		$installer->insert();

		/* actual */

		$actual = Db::forTablePrefix('articles')->findMany()->count();

		/* compare */

		$this->assertGreaterThan(0, $actual);
	}

	/**
	 * testDropMysql
	 *
	 * @since 2.4.0
	 */

	public function testDropMysql()
	{
		/* setup */

		$this->_config->set('type', 'mysql');
		$installer = new Installer();
		$installer->init($this->_config);
		$installer->drop();

		/* actual */

		$actual = Db::rawInstance()->rawQuery('SHOW TABLES LIKE \'' . $this->_config->get('prefix') . '%\'')->findMany()->count();

		/* compare */

		$this->assertEquals(0, $actual);
	}
}
