<?php
namespace Redaxscript\Template;

use Redaxscript\Db;
use Redaxscript\Config;
use Redaxscript\Console;
use Redaxscript\Breadcrumb;
use Redaxscript\Registry;
use Redaxscript\Request;
use Redaxscript\Language;
use Redaxscript\View;

/**
 * parent class to provide template tags
 *
 * @since 3.0.0
 *
 * @package Redaxscript
 * @category Template
 * @author Henry Ruhs
 */

class Tag
{
	/**
	 * breadcrumb
	 *
	 * @since 2.3.0
	 *
	 * @return string
	 */

	public static function breadcrumb()
	{
		$breadcrumb = new Breadcrumb(Registry::getInstance(), Language::getInstance());
		$breadcrumb->init();
		return $breadcrumb->render();
	}

	/**
	 * console line
	 *
	 * @since 3.0.0
	 *
	 * @return string
	 */

	public static function consoleLine()
	{
		$console = new Console\Console(Config::getInstance(), Request::getInstance());
		$output = $console->init('template');
		if (is_string($output))
		{
			return htmlentities($output);
		}
	}

	/**
	 * console form
	 *
	 * @since 3.0.0
	 *
	 * @return string
	 */

	public static function consoleForm()
	{
		$consoleForm = new View\ConsoleForm(Registry::getInstance(), Language::getInstance());
		return $consoleForm->render();
	}

	/**
	 * search form
	 *
	 * @since 3.0.0
	 *
	 * @param string $table
	 *
	 * @return string
	 */

	public static function searchForm($table = null)
	{
		$searchForm = new View\SearchForm(Registry::getInstance(), Language::getInstance());
		return $searchForm->render($table);
	}

	/**
	 * partial
	 *
	 * @since 2.3.0
	 *
	 * @param mixed $file
	 *
	 * @return string
	 */

	public static function partial($file = null)
	{
		/* handle file */

		if (is_string($file))
		{
			$file = array(
				$file
			);
		}

		/* include files */

		ob_start();
		foreach ($file as $value)
		{
			if (file_exists($value))
			{
				include($value);
			}
		}
		return ob_get_clean();
	}

	/**
	 * registry
	 *
	 * @since 2.6.0
	 *
	 * @param string $key
	 *
	 * @return string
	 */

	public static function registry($key = null)
	{
		$registry = Registry::getInstance();
		return $registry->get($key);
	}

	/**
	 * language
	 *
	 * @since 2.6.0
	 *
	 * @param string $key
	 * @param string $index
	 *
	 * @return string
	 */

	public static function language($key = null, $index = null)
	{
		$language = Language::getInstance();
		return $language->get($key, $index);
	}

	/**
	 * setting
	 *
	 * @since 2.6.0
	 *
	 * @param string $key
	 *
	 * @return string
	 */

	public static function setting($key = null)
	{
		return Db::getSetting($key);
	}

	/**
	 * content
	 *
	 * @since 2.3.0
	 *
	 * @param array $options
	 *
	 * @return string
	 */

	public static function content($options = null)
	{
		// @codeCoverageIgnoreStart
		return self::_migrate('router', array(
			$options
		));
		// @codeCoverageIgnoreEnd
	}

	/**
	 * extra
	 *
	 * @since 2.3.0
	 *
	 * @param array $optionArray
	 *
	 * @return string
	 */

	public static function extra($optionArray = array())
	{
		// @codeCoverageIgnoreStart
		return self::_migrate('extras', array(
			$optionArray['filter']
		));
		// @codeCoverageIgnoreEnd
	}

	/**
	 * navigation
	 *
	 * @since 3.0.0
	 *
	 * @param string $type
	 * @param array $optionArray
	 *
	 * @return string
	 */

	public static function navigation($type = null, $optionArray = array())
	{
		// @codeCoverageIgnoreStart
		if ($type === 'languages' || $type === 'templates')
		{
			return self::_migrate($type . '_list', array(
				$optionArray
			));
		}
		return self::_migrate('navigation_list', array(
			$type,
			$optionArray
		));
		// @codeCoverageIgnoreEnd
	}

	/**
	 * base
	 *
	 * @since 2.3.0
	 *
	 * @return string
	 */

	public static function base()
	{
		// @codeCoverageIgnoreStart
		return self::_migrate('head', array(
			'base'
		));
		// @codeCoverageIgnoreEnd
	}

	/**
	 * title
	 *
	 * @since 2.3.0
	 *
	 * @return string
	 */

	public static function title()
	{
		// @codeCoverageIgnoreStart
		return self::_migrate('head', array(
			'title'
		));
		// @codeCoverageIgnoreEnd
	}

	/**
	 * link
	 *
	 * @since 2.3.0
	 *
	 * @return string
	 */

	public static function link()
	{
		// @codeCoverageIgnoreStart
		return self::_migrate('head', array(
			'link'
		));
		// @codeCoverageIgnoreEnd
	}

	/**
	 * meta
	 *
	 * @since 2.3.0
	 *
	 * @return string
	 */

	public static function meta()
	{
		// @codeCoverageIgnoreStart
		return self::_migrate('head', array(
			'meta'
		));
		// @codeCoverageIgnoreEnd
	}

	/**
	 * style
	 *
	 * @since 2.3.0
	 *
	 * @return string
	 */

	public static function style()
	{
		// @codeCoverageIgnoreStart
		return self::_migrate('styles');
		// @codeCoverageIgnoreEnd
	}

	/**
	 * script
	 *
	 * @since 2.3.0
	 *
	 * @param string $mode
	 *
	 * @return string
	 */

	public static function script($mode = null)
	{
		// @codeCoverageIgnoreStart
		return self::_migrate('scripts', array(
			$mode
		));
		// @codeCoverageIgnoreEnd
	}

	/**
	 * migrate
	 *
	 * @since 2.3.0
	 *
	 * @param string $function
	 * @param array $parameterArray
	 *
	 * @return string
	 */

	protected static function _migrate($function = null, $parameterArray = array())
	{
		// @codeCoverageIgnoreStart
		ob_start();

		/* call with parameter */

		if (is_array($parameterArray))
		{
			call_user_func_array($function, $parameterArray);
		}

		/* else simple call */

		else
		{
			call_user_func($function);
		}
		return ob_get_clean();
		// @codeCoverageIgnoreEnd
	}
}
