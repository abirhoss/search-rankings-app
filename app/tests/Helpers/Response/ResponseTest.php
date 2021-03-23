<?php declare(strict_types=1);

namespace App\Tests\Helpers\Response;

use App\Helpers\Response\Response;
use BaseTest;


final class ResponseTest extends BaseTest
{

	public function testRenderView(): void
	{
		# Arrange
		$viewPath = "{$this->fixturesPath}/html/generic_form.html";
		$response = new Response($viewPath);

		# Act
		$expected = file_get_contents($viewPath);
		$actual = $response->renderView();

		# Assert
		$this->assertEquals($expected, $actual);
	}
}
