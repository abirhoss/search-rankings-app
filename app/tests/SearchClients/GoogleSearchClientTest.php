<?php declare(strict_types=1);

namespace App\Tests\SearchClients;

use App\SearchClients\GoogleApi;
use App\SearchClients\GoogleSearchClient;
use PHPUnit\Framework\TestCase;


final class GoogleSearchClientTest extends TestCase
{
	private string $fixturesPath;
	private GoogleSearchClient $googleSearchClient;

	public static function setUpBeforeClass(): void
	{
		$GLOBALS['config'] = yaml_parse_file(__DIR__ . '/../test_config.yaml');
	}

	protected function setUp(): void
	{
		$this->fixturesPath = __DIR__ . '/../fixtures';

		// Set up a mock GoogleApi object
		$mockGoogleApi = $this->getMockBuilder(GoogleApi::class)
			->disableOriginalConstructor()
			->getMock();

		// Return dummy search results from mockGoogleApi
		$expectedResults = ["key" => "dummy api response"];
		$mockGoogleApi->method('getGoogleApiSearchResults')
			->willReturn($expectedResults);

		// Instantiate GoogleSearchClient using mockGoogleApi
		$this->googleSearchClient = new GoogleSearchClient($mockGoogleApi);
	}

	public function testGetSearchResults(): void
	{
		# Arrange
		$expectedResults = ["key" => "dummy api response"];
		$searchKeywords = 'dummy search keyword';
		$omittedResults = 'off';

		# Act
		$actualResults = $this->googleSearchClient->getSearchResults($searchKeywords, $omittedResults);

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
