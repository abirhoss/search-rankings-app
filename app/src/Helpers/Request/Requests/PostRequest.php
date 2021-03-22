<?php

namespace App\Helpers\Request\Requests;

use App\Helpers\Request\Http\HttpRequestInterface;


/**
 * Concrete class that implements abstract Request class
 *
 * Class PostRequest
 */
class PostRequest extends Request
{
	private ?array $data = null;


	/**
	 * PostRequest constructor.
	 * @param string $url
	 * @param HttpRequestInterface $http
	 */
	public function __construct(string $url, HttpRequestInterface $http)
	{
		parent::__construct('POST', $url, $http);
	}

	/**
	 * Send the request
	 * @return string
	 */
	public function sendRequest(): string
	{
		$this->buildRequest();

		return $this->send();
	}

	/**
	 * Build the request
	 * @return mixed
	 */
	private function buildRequest()
	{
		// add data as POST body and set 'application/json' header
		$this->setHeader('Content-Type', 'application/json');

		// Set curl options
		$this->http->setOption(CURLOPT_POSTFIELDS, $this->getData());
		$this->http->setOption(CURLOPT_URL, $this->getUrl());
		$this->http->setOption(CURLOPT_HEADER, false);
		$this->http->setOption(CURLOPT_RETURNTRANSFER, true);
		$this->http->setOption(CURLOPT_HTTPHEADER, $this->getHeaders());
	}

	/**
	 * @return array|null
	 */
	public function getData(): ?array
	{
		return $this->data;
	}

	/**
	 * @param array|null $data
	 * @return PostRequest
	 */
	public function setData(?array $data): PostRequest
	{
		$this->data = $data;
		return $this;
	}
}
