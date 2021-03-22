<?php declare(strict_types=1);

namespace App\Tests\Helpers\Request\Requests;


use App\Helpers\Request\Http\CurlRequest;
use App\Helpers\Request\Requests\PostRequest;
use PHPUnit\Framework\TestCase;


final class PostRequestTest extends TestCase
{

	public function testSend(): void
	{
		# Arrange
		$expectedResponse = '{"key":"dummy api response"}';

		$mockCurl = $this->getMockBuilder(CurlRequest::class)
			->getMock();

		$mockCurl->method('execute')
			->willReturn($expectedResponse);

		$request = new PostRequest('test.com', $mockCurl);

		# Act
		$request->setData(array('dummy data'));
		$actualResponse = $request->sendRequest();

		# Assert
		self::assertEquals($expectedResponse, $actualResponse);
	}
}
