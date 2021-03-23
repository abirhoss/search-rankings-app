<?php declare(strict_types=1);

namespace App\Tests\SearchClients;

use App\SearchClients\GoogleApi;
use App\SearchClients\GoogleSearchClient;
use BaseTest;


final class GoogleSearchClientTest extends BaseTest
{
	private GoogleSearchClient $googleSearchClient;

	protected function setUp(): void
	{
		parent::setUp();

		// Set up a mock GoogleApi object
		$mockGoogleApi = $this->getMockBuilder(GoogleApi::class)
			->disableOriginalConstructor()
			->getMock();

		// Return dummy search results from mockGoogleApi
		$expectedResults = ["key" => "dummy api response"];
		$mockGoogleApi->method('getGoogleApiSearchResults')
			->willReturn($expectedResults);

		// Instantiate GoogleSearchClient using mockGoogleApi
		$this->googleSearchClient = new GoogleSearchClient($mockGoogleApi, $this->parameterStore);
	}

	public function testGetSearchResults(): void
	{
		# Arrange
		$expectedResults = ["key" => "dummy api response"];
		$searchKeywords = 'dummy search keyword';
		$includeOmittedResults = false;

		# Act
		$actualResults = $this->googleSearchClient->getSearchResults($searchKeywords, $includeOmittedResults);

		# Assert
		$this->assertEquals($expectedResults, $actualResults);
	}

	public function testGetRankPositionsFromSearchResults(): void
	{
		# Arrange
		$searchResults = file_get_contents("{$this->fixturesPath}/SearchClients/GoogleSearchClientTest/google_search_api_results.json");
		$searchResults = json_decode($searchResults, true);
		$url = 'creditorwatch.com.au';

		$expectedRankPositions = include "{$this->fixturesPath}/SearchClients/GoogleSearchClientTest/rankPositions.php";

		# Act
		$actualRankPositions = $this->googleSearchClient->getRankPositionsFromSearchResults($searchResults, $url);

		# Assert
		$this->assertEquals($expectedRankPositions, $actualRankPositions);
	}
}
