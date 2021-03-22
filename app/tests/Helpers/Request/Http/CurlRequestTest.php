<?php declare(strict_types=1);

namespace App\Tests\Helpers\Request\Http;


use App\Helpers\Request\Http\CurlRequest;
use PHPUnit\Framework\TestCase;


final class CurlRequestTest extends TestCase
{

	public function testExecute(): void
	{
		# Arrange
		$mockCurl = $this->getMockBuilder(CurlRequest::class)
			->getMock();

		$mockCurl->expects($this->exactly(1))
			->method('execute');

		# Act and Assert
		$mockCurl->execute();
	}
}
