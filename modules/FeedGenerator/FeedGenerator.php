<?php
namespace Redaxscript\Modules\FeedGenerator;

use Redaxscript\Db;
use Redaxscript\Module;
use Redaxscript\Registry;
use Redaxscript\Request;
use XMLWriter;

/**
 * generate atom feeds from content
 *
 * @since 2.3.0
 *
 * @package Redaxscript
 * @category Modules
 * @author Henry Ruhs
 */

class FeedGenerator extends Module
{
	/**
	 * array of the module
	 *
	 * @var array
	 */

	protected static $_moduleArray =
	[
		'name' => 'Feed generator',
		'alias' => 'FeedGenerator',
		'author' => 'Redaxmedia',
		'description' => 'Generate Atom feeds from content',
		'version' => '3.0.0'
	];

	/**
	 * renderStart
	 *
	 * @since 2.3.0
	 */

	public static function renderStart()
	{
		$firstParamter = Registry::get('firstParameter');
		$secondParameter = Registry::get('secondParameter');
		if ($firstParamter === 'feed' && ($secondParameter === 'articles' || $secondParameter === 'comments'))
		{
			Registry::set('renderBreak', true);
			header('content-type: application/atom+xml');
			echo self::render($secondParameter);
		}
	}

	/**
	 * render
	 *
	 * @since 2.3.0
	 *
	 * @param string $table
	 *
	 * @return string
	 */

	public static function render($table = 'articles')
	{
		/* query result */

		$resultArray[$table] = Db::forTablePrefix($table)
			->where('status', 1)
			->whereNull('access')
			->whereLanguageIs(Registry::get('language'))
			->orderGlobal('rank')
			->findMany();

		/* write xml */

		return self::_writeXML($resultArray);
	}

	/**
	 * @param array $resultArray
	 *
	 * @return string
	 */

	protected static function _writeXML($resultArray = [])
	{
		/* prepare href */

		$href = Registry::get('root') . '/' . Registry::get('parameterRoute') . Registry::get('fullRoute');
		if (Request::getQuery('l'))
		{
			$href .= Registry::get('languageRoute') . Registry::get('language');
		}

		/* write xml */

		$writer = new XMLWriter();
		$writer->openMemory();
		$writer->setIndent(true);
		$writer->setIndentString('	');
		$writer->startDocument('1.0', Db::getSetting('charset'));
		$writer->startElement('feed');
		$writer->writeAttribute('xmlns', 'http://www.w3.org/2005/Atom');
		$writer->startElement('link');
		$writer->writeAttribute('type', 'application/atom+xml');
		$writer->writeAttribute('href', $href);
		$writer->writeAttribute('rel', 'self');
		$writer->endElement();
		$writer->writeElement('id', $href);
		$writer->writeElement('title', Db::getSetting('title'));
		$writer->writeElement('updated', date('c', strtotime(Registry::get('now'))));
		$writer->startElement('author');
		$writer->writeElement('name', Db::getSetting('author'));
		$writer->endElement();

		/* process result */

		foreach ($resultArray as $table => $result)
		{
			foreach ($result as $value)
			{
				$writer->startElement('entry');
				$writer->writeElement('id', Registry::get('root') . '/' . Registry::get('parameterRoute') . build_route($table, $value->id));
				$writer->writeElement('title', $value->title);
				$writer->writeElement('updated', date('c', strtotime($value->date)));
				$writer->writeElement('content', strip_tags($value->text));
				$writer->endElement();
			}
		}
		$writer->endElement();
		$writer->endDocument();
		return $writer->outputMemory(true);
	}
}
