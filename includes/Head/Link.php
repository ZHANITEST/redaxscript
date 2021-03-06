<?php
namespace Redaxscript\Head;

use Redaxscript\Assetic;
use Redaxscript\Html;

/**
 * children class to create the link tag
 *
 * @since 3.0.0
 *
 * @package Redaxscript
 * @category Controller
 * @author Henry Ruhs
 * @author Balázs Szilágyi
 *
 * @method append($attribute = null, $value = null)
 * @method prepend($attribute = null, $value = null)
 * @method clear
 */

class Link extends HeadAbstract
{
	/**
	 * options of the link
	 *
	 * @var string
	 */

	protected $_optionArray =
	[
		'directory' => 'cache/styles',
		'extension' => 'css',
		'attribute' => 'href',
		'lifetime' => 86400
	];

	/**
	 * rewrite of the link
	 *
	 * @var string
	 */

	protected $_rewriteArray = [];

	/**
	 * append link file
	 *
	 * @since 3.0.0
	 *
	 * @param string $reference
	 *
	 * @return Link
	 */

	public function appendFile($reference = null)
	{
		$this->append(
		[
			'href' => $reference,
			'rel' => 'stylesheet'
		]);
		return $this;
	}

	/**
	 * prepend link file
	 *
	 * @since 3.0.0
	 *
	 * @param string $reference
	 *
	 * @return Link
	 */

	public function prependFile($reference = null)
	{
		$this->prepend(
		[
			'href' => $reference,
			'rel' => 'stylesheet'
		]);
		return $this;
	}

	/**
	 * remove link file
	 *
	 * @since 3.0.0
	 *
	 * @param string $reference
	 *
	 * @return Link
	 */

	public function removeFile($reference = null)
	{
		$this->remove('href', $reference);

		return $this;
	}

	/**
	 * rewrite the link
	 *
	 * @since 3.0.0
	 *
	 * @param array $rewriteArray
	 *
	 * @return Link
	 */

	public function rewrite($rewriteArray = [])
	{
		$this->_rewriteArray = array_merge($this->_rewriteArray, $rewriteArray);
		return $this;
	}

	/**
	 * concat the link
	 *
	 * @since 3.0.0
	 *
	 * @param array $optionArray
	 *
	 * @return Link
	 */

	public function concat($optionArray = [])
	{
		$optionArray = array_merge($this->_optionArray, $optionArray);
		$loader = new Assetic\Loader();
		$loader
			->init(self::$_collectionArray[self::$_namespace])
			->concat($optionArray, $this->_rewriteArray);

		/* update collection */

		self::$_collectionArray[self::$_namespace] = $loader->getCollectionArray();
		return $this;
	}

	/**
	 * render the link
	 *
	 * @since 3.0.0
	 *
	 * @return string
	 */

	public function render()
	{
		$output = null;

		/* html elements */

		$metaElement = new Html\Element();
		$metaElement->init('link');
		$collectionArray = self::$_collectionArray[self::$_namespace];
		$collectionKeys = array_keys($collectionArray);
		$lastKey = end($collectionKeys);

		/* process collection */

		foreach ($collectionArray as $key => $value)
		{
			$output .= $metaElement
				->copy()
				->attr($value);
			if ($key !== $lastKey)
			{
				$output .= PHP_EOL;
			}
		}
		$this->clear();
		return $output;
	}
}