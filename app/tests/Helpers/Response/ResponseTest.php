<?php declare(strict_types=1);

namespace App\Tests\Helpers\Response;

use App\Helpers\Response\Response;
use PHPUnit\Framework\TestCase;


final class ResponseTest extends TestCase
{
	private string $fixturesPath;

	public static function setUpBeforeClass(): void
	{
		$GLOBALS['config'] = yaml_parse_file(__DIR__ . '/../../test_config.yaml');
	}

	protected function setUp(): void
	{
		$this->fixturesPath = __DIR__ . '/../../fixtures';
	}

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
