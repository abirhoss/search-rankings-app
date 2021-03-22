<?php declare(strict_types=1);

namespace App\Tests\Controller;

use App\Controller\SearchController;
use App\Helpers\Request\GetRequest;
use App\Helpers\Request\RequestFactory;
use App\Helpers\Response\Response;
use App\SearchClients\GoogleSearchClient;
use PHPUnit\Framework\TestCase;

final class SearchControllerTest extends TestCase
{
	private string $fixturesPath;
	private string $viewRootDir;

	public static function setUpBeforeClass(): void
	{
		$GLOBALS['config'] = yaml_parse_file(__DIR__ . '/../test_config.yaml');
	}

	protected function setUp(): void
	{
		$this->fixturesPath = __DIR__ . '/../fixtures';
		$this->viewRootDir = $GLOBALS['config']['app_root'] . '/src/View/';
	}

	public function testSearchFormAction(): void
	{
		# Arrange
		$expectedViewPath = "{$this->fixturesPath}/html/search_form.html";
		$actualViewPath = "{$this->viewRootDir}/search/searchform.template.php";

		$expectedView = file_get_contents($expectedViewPath);
		$response = new Response($actualViewPath);

		# Act
		$searchController = new SearchController($response);
		$actualView = $searchController->searchFormAction();

		# Assert
		$this->assertEquals($expectedView, $actualView);
	}

	public function testSearchAction(): void
	{
		# Arrange
		$expectedViewPath = "{$this->fixturesPath}/html/search_rankings.html";
		$actualViewPath = "{$this->viewRootDir}/search/search.template.php";

		$expectedView = file_get_contents($expectedViewPath);
		$response = new Response($actualViewPath);

		$searchFormInput['searchKeywords'] = 'creditorwatch';
		$searchFormInput['url'] = 'creditorwatch.com.au';
		$rankPositions = array(1);

		// mock GoogleSearchClient
		$mockGoogleSearchSearchClient = $this->getMockBuilder(GoogleSearchClient::class)
			->disableOriginalConstructor()
			->getMock();

		$mockGoogleSearchSearchClient->method('getSearchResults')
			->willReturn([]);

		$mockGoogleSearchSearchClient->method('getRankPositionsFromSearchResults')
			->willReturn($rankPositions);

		# Act
		$searchController = new SearchController($response);
		$actualView = $searchController->searchAction($searchFormInput, $mockGoogleSearchSearchClient);

		# Assert
		$this->assertEquals($expectedView, $actualView);
	}
}
