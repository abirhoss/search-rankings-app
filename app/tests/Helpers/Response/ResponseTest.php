<?php declare(strict_types=1);

namespace App\Tests;

use App\Helpers\Response\Response;
use PHPUnit\Framework\TestCase;


final class ResponseTest extends TestCase
{
	private string $fixturesPath;

	public static function setUpBeforeClass(): void
	{
		$GLOBALS['config'] = yaml_parse_file(__DIR__ . '/../../test_config.yaml');
	}

	public function testRenderView(): void
	{
		# Arrange
		$viewPath = "{$this->fixturesPath}/html/form.html";
		$response = new Response($viewPath);

		# Act
		$expected = file_get_contents($viewPath);
		$actual = $response->renderView();

		# Assert
		$this->assertEquals($expected, $actual);
	}

	protected function setUp(): void
	{
		$this->fixturesPath = __DIR__ . '/../../fixtures';
	}
}
