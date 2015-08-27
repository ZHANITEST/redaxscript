<?php
namespace Redaxscript\Modules\DirectoryLister;

use Redaxscript\Db;
use Redaxscript\Directory;
use Redaxscript\Element;
use Redaxscript\Filter;
use Redaxscript\Language;
use Redaxscript\Registry;
use Redaxscript\Request;

/**
 * simple directory lister
 *
 * @since 2.6.0
 *
 * @package Redaxscript
 * @category Modules
 * @author Henry Ruhs
 */

class DirectoryLister extends Config
{
	/**
	 * array of the module
	 *
	 * @var array
	 */

	protected static $_moduleArray = array(
		'name' => 'Directory lister',
		'alias' => 'DirectoryLister',
		'author' => 'Redaxmedia',
		'description' => 'Simple directory lister',
		'version' => '2.6.0'
	);

	/**
	 * loaderStart
	 *
	 * @since 2.6.0
	 */

	public static function loaderStart()
	{
		global $loader_modules_styles;
		$loader_modules_styles[] = 'modules/DirectoryLister/styles/directory_lister.css';
	}

	/**
	 * render
	 *
	 * @since 2.6.0
	 *
	 * @param string $directory
	 * @param array $options
	 *
	 * @return string
	 */

	public static function render($directory = null, $options = null)
	{
		$output = '';
		$outputDirectory = '';
		$outputFile = '';

		/* hash option */

		if ($options['hash'])
		{
			$hashString = '#' . $options['hash'];
		}

		/* handle query */

		$directoryQuery = Request::getQuery('d');
		if ($directoryQuery && $directory !== $directoryQuery)
		{
			$pathFilter = new Filter\Path();
			$directory = $pathFilter->sanitize($directoryQuery);
			$parentDirectory = $pathFilter->sanitize(dirname($directory));
		}

		/* has directory */

		if (is_dir($directory))
		{
			/* html elements */

			$linkElement = new Element('a', array(
					'class' => self::$_config['className']['link']
			));
			$textSizeElement = new Element('span', array(
					'class' => self::$_config['className']['textSize']
			));
			$textDateElement = new Element('span', array(
					'class' => self::$_config['className']['textDate']
			));
			$listElement = new Element('ul', array(
					'class' => self::$_config['className']['list']
			));

			/* list directory object */

			$listDirectory = new Directory();
			$listDirectory->init($directory);
			$listDirectoryArray = $listDirectory->getArray();

			/* date format */

			$dateFormat = Db::getSettings('date');

			/* parent directory */

			if (is_dir($parentDirectory))
			{
				$outputDirectory .= '<li>';
				$outputDirectory .= $linkElement
					->copy()
					->attr(array(
						'href' => Registry::get('rewriteRoute') . Registry::get('fullRoute') . '&d=' . $parentDirectory . $hashString,
						'title' => Language::get('directory_parent', '_directory_lister')
					))
					->addClass(self::$_config['className']['types']['directoryParent'])
					->text(Language::get('directory_parent', '_directory_lister'));
				$outputDirectory .= '</li>';
			}

			/* process directory */

			foreach ($listDirectoryArray as $key => $value)
			{
				$path = $directory . '/' . $value;
				$fileExtension = pathinfo($path, PATHINFO_EXTENSION);
				$text = $value;

				/* replace option */

				if ($options['replace'])
				{
					foreach ($options['replace'] as $replaceKey => $replaceValue)
					{
						if ($replaceKey === self::$_config['replaceKey']['extension'])
						{
							$replaceKey = $fileExtension;
						}
						$text = str_replace($replaceKey, $replaceValue, $text);
					}
				}

				/* handle directory */

				if (is_dir($path))
				{
					$outputDirectory .= '<li>';
					$outputDirectory .= $linkElement
						->copy()
						->attr(array(
							'href' => Registry::get('rewriteRoute') . Registry::get('fullRoute') . '&d=' . $path . $hashString,
							'title' => Language::get('directory', '_directory_lister')
						))
						->addClass(self::$_config['className']['types']['directory'])
						->text($text);
					$outputDirectory .= $textSizeElement->copy();
					$outputDirectory .= $textDateElement
						->copy()
						->text(date($dateFormat, filectime($path)));
					$outputDirectory .= '</li>';
				}

				/* else handle file */

				else if (is_file($path))
				{
					if (array_key_exists($fileExtension, self::$_config['extension']))
					{
						$fileType = self::$_config['extension'][$fileExtension];
						$outputFile .= '<li>';
						$outputFile .= $linkElement
							->copy()
							->attr(array(
								'href' => $path,
								'title' => Language::get('file', '_directory_lister')
							))
							->addClass(self::$_config['className']['types'][$fileType])
							->text($text);
						$outputFile .= $textSizeElement
							->copy()
							->attr('data-unit', self::$_config['size']['unit'])
							->html(ceil(filesize($path) / self::$_config['size']['divider']));
						$outputFile .= $textDateElement
							->copy()
							->html(date($dateFormat, filectime($path)));
						$outputFile .= '</li>';
					}
				}
			}

			/* collect list output */

			if ($outputDirectory || $outputFile)
			{
				$output = $listElement->html($outputDirectory . $outputFile);
			}
		}
		return $output;
	}
}
