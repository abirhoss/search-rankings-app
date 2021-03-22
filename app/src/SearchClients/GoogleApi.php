<?php

namespace App\SearchClients;

use App\Helpers\Request\RequestInterface;


/**
 * A specific Adaptee class for Google Search API that is incompatible with the Target interface (SearchClientInterface)
 *
 * This class can also act as a Facade that provides a simple method for making Google search queries.
 * Such a method would hide all the complexities of making the requests and interacting with other services.
 *
 * Class GoogleApi
 */
class GoogleApi
{
	private string $apiKey;
	private RequestInterface $requestClient;

	/**
	 * GoogleApi constructor.
	 * @param string $apiKey
	 * @param RequestInterface $requestClient
	 */
	public function __construct(string $apiKey, RequestInterface $requestClient)
	{
		$this->apiKey = $apiKey;
		$this->requestClient = $requestClient;
	}

	/**
	 * @param array $searchParameters
	 * @return array
	 */
	public function getGoogleApiSearchResults(array $searchParameters): array
	{
		// Add Authentication
		$searchParameters['api_key'] = $this->apiKey;

		// Prepare GET request
		$this->requestClient->setQueryParameters($searchParameters);

		// Send search request and return response
		$response = $this->requestClient->sendRequest();

		// Decode response JSON into array
		return json_decode($response, true);
	}
}
