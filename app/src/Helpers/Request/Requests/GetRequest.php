<?php

namespace App\Helpers\Request\Requests;


use App\Helpers\Request\Http\HttpRequestInterface;

/**
 * Concrete class that implements abstract Request class
 *
 * Class GetRequest
 */
class GetRequest extends Request
{

	/**
	 * GetRequest constructor.
	 * @param string $url
	 * @param HttpRequestInterface $http
	 */
	public function __construct(string $url, HttpRequestInterface $http)
	{
		parent::__construct('GET', $url, $http);
	}

	/**
	 * Send the request
	 * @return string
	 */
	public function sendRequest(): string
	{
		$this->buildRequest();

		// Use parent 'send' function to execute the request
		return $this->send();
	}

	/**
	 * Build the request
	 * @return mixed
	 */
	private function buildRequest()
	{
		$this->addQueryParametersToUrl();

		// Set the URL
		$this->http->setOption(CURLOPT_URL, $this->getUrl());
		$this->http->setOption(CURLOPT_HEADER, false);
		$this->http->setOption(CURLOPT_RETURNTRANSFER, true);

		// Add headers if provided
		$this->getHeaders() ? $this->http->setOption(CURLOPT_HTTPHEADER, $this->getHeaders()) : '';
	}

	/**
	 * Add query parameters to the request URL
	 * @return void
	 */
	private function addQueryParametersToUrl(): void
	{
		if (!$this->getQueryParameters()) {
			return;
		}

		$queryString = http_build_query($this->getQueryParameters());
		$this->setUrl($this->getUrl() . '?' . $queryString);
	}
}
