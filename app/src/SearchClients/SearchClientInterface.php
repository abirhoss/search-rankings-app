<?php

namespace App\SearchClients;


/**
 * A Target interface class for search clients
 *
 * Interface SearchClientInterface
 */
interface SearchClientInterface
{
	/**
	 * @param string $searchKeywords
	 * @param string $omittedResults
	 * @return array
	 */
	public function getSearchResults(string $searchKeywords, string $omittedResults): array;

	/**
	 * @param array $searchResults
	 * @param string $domain
	 * @return array
	 */
	public function getRankPositionsFromSearchResults(array $searchResults, string $domain): array;
}
