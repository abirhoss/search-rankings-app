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
	 * @param ?string $similarResults
	 * @return array
	 * @throws Exception
	 */
	public function getSearchResults(string $searchKeywords, ?string $similarResults): array
	{
		// Get the google search parameters
		$searchParameters = $this->getGoogleSearchParameters($searchKeywords, $similarResults);

		// Get google search results
		return $this->google->getGoogleApiSearchResults($searchParameters);
	}

	/**
	 * Builds parameters for a google search
	 *
	 * @param string $searchKeywords
	 * @param ?string $similarResults
	 * @return array
	 */
	private function getGoogleSearchParameters(string $searchKeywords, ?string $similarResults): array
	{
		// Get google search params
		$searchParams = $GLOBALS['config']['search_params']['google'];
		$includeSimilarResults = $similarResults == "on" ? "0" : "1";

		return [
			'q' => $searchKeywords,
			'engine' => $searchParams['search_engine'],
			'google_domain' => $searchParams['google_domain'],
			'location' => $searchParams['location'],
			'gl' => $searchParams['country'],
			'hl' => $searchParams['language'],
			'num' => $searchParams['limit'],
			'filter' => $includeSimilarResults
		];
	}

	/**
	 * Searches through the search results and returns the positions of wherever the target website is found
	 *
	 * @param array $searchResults
	 * @param string $website
	 * @return array
	 */
	public function getRankPositionsFromSearchResults(array $searchResults, string $website): array
	{
		$rankPositions = [];

		foreach ($searchResults['organic_results'] as $result) {
			// Check if result website contains our target website string
			$websiteFoundInResult = strpos($result['link'], $website);

			if ($websiteFoundInResult === false) {
				continue;
			}

			$rankPositions[] = $result['position'];
		}

		return $rankPositions;
	}
}
