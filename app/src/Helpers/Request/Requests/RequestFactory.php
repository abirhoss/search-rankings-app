<?php

namespace App\Helpers\Request\Requests;


use App\Helpers\Request\Http\HttpRequestInterface;
use App\Helpers\Request\RequestInterface;
use Exception;

/**
 * Factory class for creating the appropriate Request object based on request method
 *
 * Class RequestFactory
 */
class RequestFactory
{
	/**
	 * @param string $method
	 * @param string $url
	 * @param HttpRequestInterface $http
	 * @return Request
	 * @throws Exception
	 */
	public static function create(string $method, string $url, HttpRequestInterface $http): RequestInterface
	{
		$method = strtoupper($method);

		switch ($method) {
			case 'GET':
				return new GetRequest($url, $http);

			case 'POST':
				return new PostRequest($url, $http);

			default:
				// TODO: Shortcut. This should be throwing a more specific Exception class
				throw new Exception("No {$method} request method found");
		}
	}
}
