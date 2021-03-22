<?php declare(strict_types=1);

namespace App\Tests\Helpers\Request\Requests;


use App\Helpers\Request\Http\CurlRequest;
use App\Helpers\Request\RequestInterface;
use App\Helpers\Request\Requests\RequestFactory;
use PHPUnit\Framework\TestCase;


final class RequestFactoryTest extends TestCase
{

	public function testCreate(): void
	{
		# Arrange
		$method = 'GET';
		$url = 'test.com';
		$expectedInstanceType = RequestInterface::class;

		$mockCurl = $this->getMockBuilder(CurlRequest::class)
			->getMock();

		# Act
		$actualInstance = RequestFactory::create($method, $url, $mockCurl);

		# Assert
		$this->assertInstanceOf($expectedInstanceType, $actualInstance);
	}
}
