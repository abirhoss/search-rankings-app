<?php

namespace App\SearchClients;


use App\Helpers\ParameterStore;

/**
 * An Adapter class that's compatible with the Target interface and wraps around an Adaptee class.
 *
 * Class GoogleSearchClient
 */
class GoogleSearchClient implements SearchClientInterface
{

	private GoogleApi $google;
	protected ParameterStore $parameterStore;

	/**
	 * GoogleSearchClient constructor.
	 * @param GoogleApi $google
	 * @param ParameterStore $parameterStore
	 */
	public function __construct(GoogleApi $google, ParameterStore $parameterStore)
	{
		$this->google = $google;
		$this->parameterStore = $parameterStore;
	}

	/**
	 * Wrapper function that makes a google search
	 *
	 * @param string $searchKeywords
	 * @param bool $includeOmittedResults
	 * @return array
	 */
	public function getSearchResults(string $searchKeywords, bool $includeOmittedResults): array
	{
		// Get the google search parameters
		$searchParameters = $this->getGoogleSearchParameters($searchKeywords, $includeOmittedResults);

		// Get google search results
		return $this->google->getGoogleApiSearchResults($searchParameters);
	}

	/**
	 * Builds parameters for a google search
	 *
	 * @param string $searchKeywords
	 * @param bool $includeOmittedResults
	 * @return array
	 */
	private function getGoogleSearchParameters(string $searchKeywords, bool $includeOmittedResults): array
	{
		// Get google search params
		$googleSearchConfig = $this->parameterStore->getParameter('search_config')['google'];
		$filterOmittedResults = $includeOmittedResults ? "0" : "1";

		return [
			'q' => $searchKeywords,
			'engine' => $googleSearchConfig['search_engine'],
			'google_domain' => $googleSearchConfig['google_domain'],
			'location' => $googleSearchConfig['location'],
			'gl' => $googleSearchConfig['country'],
			'hl' => $googleSearchConfig['language'],
			'num' => $googleSearchConfig['limit'],
			'filter' => $filterOmittedResults
		];
	}

	/**
	 * Searches through the search results and returns the positions of wherever the domain is found
	 *
	 * @param array $searchResults
	 * @param string $domain
	 * @return array
	 */
	public function getRankPositionsFromSearchResults(array $searchResults, string $domain): array
	{
		$rankPositions = [];

		foreach ($searchResults['organic_results'] as $result) {
			// Check if result link contains our target domain string
			$domainFoundInResult = strpos($result['link'], $domain);

			// Continue to next search result if domain is not found in result link
			if ($domainFoundInResult === false) {
				continue;
			}

			// Add result position to $rankPositions
			$rankPositions[] = $result['position'];
		}

		return $rankPositions;
	}
}
