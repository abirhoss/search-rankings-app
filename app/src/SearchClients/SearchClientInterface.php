<?php

namespace App\SearchClients;


/**
 * A Target interface class for search clients
 *
 * Interface SearchClientInterface
 */
interface SearchClientInterface
{
	public function getSearchResults(string $searchKeywords, string $similarResults): array;

	public function getRankPositionsFromSearchResults(array $searchResults, string $website): array;
}
