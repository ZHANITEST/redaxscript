<?php
namespace Redaxscript\Console\Command;

use Redaxscript\Console\Parser;
use Redaxscript\Db;

/**
 * children class to execute the setting command
 *
 * @since 3.0.0
 *
 * @package Redaxscript
 * @category Console
 * @author Henry Ruhs
 */

class Setting extends CommandAbstract
{
	/**
	 * array of the command
	 *
	 * @var array
	 */

	protected $_commandArray = array(
		'setting' => array(
			'description' => 'Setting command',
			'argumentArray' => array(
				'list' => array(
					'description' => 'List the settings'
				),
				'set' => array(
					'description' => 'Set the setting',
					'optionArray' => array(
						'<key>' => array(
							'description' => 'Required setting <key>'
						),
						'<value>' => array(
							'description' => 'Required setting <value>'
						)
					)
				)
			)
		)
	);
	
	/**
	 * run the command
	 *
	 * @since 3.0.0
	 */

	public function run()
	{
		$parser = new Parser($this->_request);
		$parser->init(php_sapi_name());

		/* run command */

		$argumentKey = $parser->getArgument(1);
		if ($argumentKey === 'list')
		{
			return $this->_list();
		}
		if ($argumentKey === 'set')
		{
			return $this->_set($parser->getOption());
		}
		return $this->getHelp();
	}

	/**
	 * set the setting
	 *
	 * @since 3.0.0
	 *
	 * @param array $optionArray
	 */

	public function _set($optionArray = array())
	{
		$key = $optionArray['key'] ? $optionArray['key'] : readline('key:');
		$value = $optionArray['value'] ? $optionArray['value'] : readline('value:');
		if ($key && $value)
		{
			Db::setSetting($key, $value);
		}		
	}

	/**
	 * list the settings
	 *
	 * @since 3.0.0
	 *
	 * @return string
	 */

	public function _list()
	{
		$output = null;
		$settings = Db::getSetting();

		/* process settings */

		foreach ($settings as $setting)
		{
			$output .= str_pad($setting->name, 30) . $setting->value . PHP_EOL;
		}
		return $output;
	}
}
