<?php declare(strict_types=1);

namespace App\Tests\SearchClients;

use App\Helpers\Request\Requests\GetRequest;
use App\SearchClients\GoogleApi;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;


final class GoogleApiTest extends TestCase
{
	public function testGetGoogleApiSearchResults(): void
	{
		# Arrange
		$apiKey = 'dummy_api_key';
		$searchParameters = array(
			'q' => 'creditorwatch',
			'engine' => 'google',
			'google_domain' => 'google.com.au',
		);
		$expectedJson = '{"key" : "dummy api response"}';
		$expectedResults = ["key" => "dummy api response"];

		// mock get request
		$mockGetRequest = $this->getMockBuilder(GetRequest::class)
			->disableOriginalConstructor()
			->getMock();

		$mockGetRequest->method('sendRequest')
			->willReturn($expectedJson);

		$google = new GoogleApi($apiKey, $mockGetRequest);

		# Act
		$actualResults = $google->getGoogleApiSearchResults($searchParameters);

		# Assert
		assertEquals($expectedResults, $actualResults);
	}
}
