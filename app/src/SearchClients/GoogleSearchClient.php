<?php

namespace App\SearchClients;



/**
 * An Adapter class that's compatible with the Target interface and wraps around an Adaptee class.
 *
 * Class GoogleSearchClient
 */
class GoogleSearchClient implements SearchClientInterface
{

	private GoogleApi $google;

	/**
	 * GoogleSearchClient constructor.
	 * @param GoogleApi $google
	 */
	public function __construct(GoogleApi $google)
	{
		$this->google = $google;
	}

	/**
	 * Wrapper function that makes a google search
	 *
	 * @param string $searchKeywords
	 * @param ?string $omittedResults
	 * @return array
	 */
	public function getSearchResults(string $searchKeywords, ?string $omittedResults): array
	{
		// Get the google search parameters
		$searchParameters = $this->getGoogleSearchParameters($searchKeywords, $omittedResults);

		// Get google search results
		return $this->google->getGoogleApiSearchResults($searchParameters);
	}

	/**
	 * Builds parameters for a google search
	 *
	 * @param string $searchKeywords
	 * @param ?string $omittedResults
	 * @return array
	 */
	private function getGoogleSearchParameters(string $searchKeywords, ?string $omittedResults): array
	{
		// Get google search params
		$searchParams = $GLOBALS['config']['search_params']['google'];
		$includeOmittedResults = $omittedResults == "on" ? "0" : "1";

		return [
			'q' => $searchKeywords,
			'engine' => $searchParams['search_engine'],
			'google_domain' => $searchParams['google_domain'],
			'location' => $searchParams['location'],
			'gl' => $searchParams['country'],
			'hl' => $searchParams['language'],
			'num' => $searchParams['limit'],
			'filter' => $includeOmittedResults
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
