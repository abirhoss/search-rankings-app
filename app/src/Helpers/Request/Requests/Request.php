<?php

namespace App\Helpers\Request\Requests;


use App\Helpers\Request\Http\HttpRequestInterface;
use App\Helpers\Request\RequestInterface;

/**
 * Class Request
 */
abstract class Request implements RequestInterface
{
	public HttpRequestInterface $http;
	protected string $method;
	protected string $url;
	protected ?array $headers = null;
	protected ?array $queryParameters = null;

	/**
	 * Request constructor.
	 * @param string $method
	 * @param string $url
	 */
	public function __construct(string $method, string $url, HttpRequestInterface $http)
	{
		$this->method = $method;
		$this->url = $url;
		$this->http = $http;
	}

	/**
	 * @return string
	 */
	public function getMethod(): string
	{
		return $this->method;
	}

	/**
	 * @param string $method
	 * @return Request
	 */
	public function setMethod(string $method): Request
	{
		$this->method = $method;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getUrl(): string
	{
		return $this->url;
	}

	/**
	 * @param string $url
	 * @return Request
	 */
	public function setUrl(string $url): Request
	{
		$this->url = $url;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getHeaders(): ?array
	{
		return $this->headers;
	}

	/**
	 * @param array $headers
	 * @return Request
	 */
	public function setHeaders(array $headers): Request
	{
		$this->headers = $headers;
		return $this;
	}

	/**
	 * @param string $key
	 * @param string $value
	 * @return Request
	 */
	public function setHeader(string $key, string $value): Request
	{
		$this->headers[$key] = $value;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getQueryParameters(): ?array
	{
		return $this->queryParameters;
	}

	/**
	 * @param array $queryParameters
	 * @return Request
	 */
	public function setQueryParameters(array $queryParameters): Request
	{
		$this->queryParameters = $queryParameters;
		return $this;
	}

	/**
	 * Send the request
	 * @return string
	 */
	public function send(): string
	{
		// Execute request
		$response = $this->http->execute();

		// Close curl session
		$this->http->close();

		return $response;
	}
}
