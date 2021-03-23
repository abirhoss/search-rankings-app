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
	 * @param bool $includeOmittedResults
	 * @return array
	 */
	public function getSearchResults(string $searchKeywords, bool $includeOmittedResults): array;

	/**
	 * @param array $searchResults
	 * @param string $domain
	 * @return array
	 */
	public function getRankPositionsFromSearchResults(array $searchResults, string $domain): array;
}
