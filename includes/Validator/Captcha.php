<?php
namespace Redaxscript\Validator;

use Redaxscript\Config;
use Redaxscript\Db;
use Redaxscript\Hash;

/**
 * children class to validate captcha raw again hash
 *
 * @since 2.2.0
 *
 * @category Redaxscript
 * @package Validator
 * @author Henry Ruhs
 * @author Sven Weingartner
 */

class Captcha implements ValidatorInterface
{
	/**
	 * validate the captcha
	 *
	 * @since 2.2.0
	 *
	 * @param string $raw plain answer
	 * @param string $hash hashed solution
	 *
	 * @return integer
	 */

	public function validate($raw = null, $hash = null)
	{
		$output = ValidatorInterface::FAILED;
		$captchaHash = new Hash(Config::getInstance());

		/* validate captcha */

		if ($captchaHash->validate($raw, $hash) || Db::getSettings('captcha') < 1)
		{
			$output = ValidatorInterface::PASSED;
		}
		return $output;
	}
}