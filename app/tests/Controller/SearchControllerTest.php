<?php declare(strict_types=1);

namespace App\Tests\Controller;

use App\Controller\SearchController;
use App\Helpers\Response\Response;
use App\SearchClients\GoogleSearchClient;
use BaseTest;

final class SearchControllerTest extends BaseTest
{
	public function testSearchFormAction(): void
	{
		# Arrange
		$expectedViewPath = "{$this->fixturesPath}/html/search_form.html";
		$appRootPath = $this->parameterStore->getParameter('app_root');
		$actualViewPath = "{$appRootPath}/src/View/search/searchform.template.php";

		$expectedView = file_get_contents($expectedViewPath);
		$response = new Response($actualViewPath);

		# Act
		$searchController = new SearchController($response, $this->parameterStore);
		$actualView = $searchController->searchFormAction();

		# Assert
		$this->assertEquals($expectedView, $actualView);
	}

	public function testSearchAction(): void
	{
		# Arrange
		$expectedViewPath = "{$this->fixturesPath}/html/search_rankings.html";
		$appRootPath = $this->parameterStore->getParameter('app_root');
		$actualViewPath = "{$appRootPath}/src/View/search/search.template.php";

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
		$searchController = new SearchController($response, $this->parameterStore);
		$actualView = $searchController->searchAction($searchFormInput, $mockGoogleSearchSearchClient);

		# Assert
		$this->assertEquals($expectedView, $actualView);
	}
}
