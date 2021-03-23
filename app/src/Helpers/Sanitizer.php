<?php

namespace App\Helpers;

/**
 * Class Sanitizer
 */
class Sanitizer
{
	/**
	 * @param array $textArray
	 * @return ?array
	 */
	public static function sanitizeTextArray(array $textArray): ?array
	{
		return filter_var_array($textArray, FILTER_SANITIZE_STRING);
	}

	/**
	 * Extracts the domain (eg. 'creditorwatch.com.au') from a URL (eg. 'https://www.creditorwatch.com.au')
	 *
	 * @param string $url
	 * @return string
	 */
	public static function getDomainFromUrl(string $url): string
	{
		$url = strtolower($url);

		// Get the url with the 'https://' or 'http://' scheme
		$parsedUrl = parse_url($url);
		$urlWithoutScheme = isset($parsedUrl['host']) ? $parsedUrl['host'] : $parsedUrl['path'];

		// Remove 'www.' from the beginning of the url if it exists
		$regexPattern = '/^www\.?/i';
		return preg_replace($regexPattern, '', $urlWithoutScheme);
	}
}
