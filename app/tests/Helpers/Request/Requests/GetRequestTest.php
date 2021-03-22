<?php declare(strict_types=1);

namespace App\Tests\Helpers\Request\Requests;


use App\Helpers\Request\Http\CurlRequest;
use App\Helpers\Request\Requests\GetRequest;
use PHPUnit\Framework\TestCase;


final class GetRequestTest extends TestCase
{

	public function testSend(): void
	{
		# Arrange
		$expectedResponse = '{"key":"dummy api response"}';

		$mockCurl = $this->getMockBuilder(CurlRequest::class)
			->getMock();

		$mockCurl->method('execute')
			->willReturn($expectedResponse);

		$request = new GetRequest('test.com', $mockCurl);

		# Act
		$actualResponse = $request->sendRequest();

		# Assert
		self::assertEquals($expectedResponse, $actualResponse);
	}
}
