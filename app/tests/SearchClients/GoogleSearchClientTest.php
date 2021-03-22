<?php declare(strict_types=1);

namespace App\Tests;

use App\SearchClients\GoogleApi;
use App\SearchClients\GoogleSearchClient;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;


final class GoogleSearchClientTest extends TestCase
{
	private string $fixturesPath;

	public static function setUpBeforeClass(): void
	{
		$GLOBALS['config'] = yaml_parse_file(__DIR__ . '/../test_config.yaml');
	}

	public function testGetSearchResults(): void
	{
		# Arrange
		$searchKeywords = 'dummy search keyword';
		$similarResults = 'off';
		$expectedResults = ["key" => "dummy api response"];

		$mockGoogle = $this->getMockBuilder(GoogleApi::class)
			->disableOriginalConstructor()
			->getMock();

		$mockGoogle->method('getGoogleApiSearchResults')
			->willReturn($expectedResults);

		$google = new GoogleSearchClient($mockGoogle);

		# Act
		$actualResults = $google->getSearchResults($searchKeywords, $similarResults);

		# Assert
		assertEquals($expectedResults, $actualResults);
	}

	public function testGetRankPositionsFromSearchResults(): void
	{
		# Arrange
		$searchResults = file_get_contents("{$this->fixturesPath}/SearchClients/google_search_results.json");
		$searchResults = json_decode($searchResults, true);
		$website = 'creditorwatch';

		$expectedRankPositions = include "{$this->fixturesPath}/SearchClients/rankPositions.php";

		$mockGoogle = $this->getMockBuilder(GoogleApi::class)
			->disableOriginalConstructor()
			->getMock();

		$googleSearchClient = new GoogleSearchClient($mockGoogle);

		# Act
		$actualRankPositions = $googleSearchClient->getRankPositionsFromSearchResults($searchResults, $website);

		# Assert
		assertEquals($expectedRankPositions, $actualRankPositions);
	}

	protected function setUp(): void
	{
		$this->fixturesPath = __DIR__ . '/../fixtures';
	}
}
