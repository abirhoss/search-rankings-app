<?php

namespace App\Controller;


use App\Helpers\Response\Response;
use App\Helpers\Sanitizer;
use App\SearchClients\GoogleSearchClient;

/**
 * Class SearchController
 */
class SearchController extends AbstractController
{
	/**
	 * SearchController constructor.
	 * @param Response $response
	 */
	public function __construct(Response $response)
	{
		parent::__construct($response);
	}

	/**
	 * Action for displaying the search form to the user
	 *
	 * @return string
	 */
	public function searchFormAction(): string
	{
		// Return view template based on controller and action name
		return $this->response->renderView();
	}

	/**
	 * Action for performing a search based on search form input and displaying the results
	 *
	 * @param array $searchFormInput
	 * @param GoogleSearchClient $searchClient
	 * @return string
	 */
	public function searchAction(array $searchFormInput, GoogleSearchClient $searchClient): string
	{
		// Sanitize search form input
		$searchKeywords = Sanitizer::sanitizeText($searchFormInput['searchKeywords']);
		$url = Sanitizer::sanitizeText($searchFormInput['url']);
		$omittedResults = isset($searchFormInput['omittedResults']) ? $searchFormInput['omittedResults'] : "No";

		// Get the domain from the url
		$domain = Sanitizer::getDomainFromUrl($url);

		// Use Adapter $searchClient class to perform search and get rank positions
		$searchResults = $searchClient->getSearchResults($searchKeywords, $omittedResults);
		$rankPositions = $searchClient->getRankPositionsFromSearchResults($searchResults, $domain);

		// Prepare response template variables
		$responseVars = $this->prepareResponseVars($searchKeywords, $url, $domain, $omittedResults, $rankPositions);

		// Return view template based on controller and action name
		return $this->response->renderView($responseVars);
	}

	/**
	 * Prepares variables for the view template
	 *
	 * @param string $searchKeywords
	 * @param string $domain
	 * @param string $omittedResults
	 * @param array $rankPositions
	 * @return array
	 */
	private function prepareResponseVars(string $searchKeywords, string $url, string $domain, string $omittedResults, array $rankPositions): array
	{
		$domainCount = count($rankPositions);
		$rankingList = $this->convertRankArrayToCsv($rankPositions);
		$resultsLimit = $GLOBALS['config']['search_params']['google']['limit'];

		return [
			'searchKeywords' => $searchKeywords,
			'url' => $url,
			'domain' => $domain,
			'resultsLimit' => $resultsLimit,
			'omittedResults' => $omittedResults,
			'rankingList' => $rankingList,
			'domainCount' => $domainCount
		];
	}

	/**
	 * Takes an array of $rankPositions and returns values in a comma-separated string
	 * Returns "0" if $rankPositions is false
	 * Eg. [0,1,2,3] -> "0,1,2,3"
	 *
	 * @param array $rankPositions
	 * @return string
	 */
	private function convertRankArrayToCsv(array $rankPositions): string
	{
		if (!$rankPositions) {
			return "0";
		}

		return implode(', ', $rankPositions);
	}
}
