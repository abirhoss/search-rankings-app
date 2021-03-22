<?php

namespace App\Helpers;

/**
 * Class Sanitizer
 */
class Sanitizer
{
	/**
	 * @param string $text
	 * @return string
	 */
	public static function sanitizeText(string $text): string
	{
		return filter_var($text, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	}

}
