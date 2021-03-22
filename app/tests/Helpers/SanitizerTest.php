<?php declare(strict_types=1);

namespace App\Tests\Helpers;


use App\Helpers\Sanitizer;
use PHPUnit\Framework\TestCase;


final class SanitizerTest extends TestCase
{
	private string $fixturesPath;

	protected function setUp(): void
	{
		$this->fixturesPath = __DIR__ . '/../fixtures';
	}

	public function testSanitizeText(): void
	{
		# Arrange
		$rawText = "<script\\x20type=\"text/javascript\">javascript:alert(1);</script>";
		$expected = "javascript:alert(1);";

		# Act
		$actual = Sanitizer::sanitizeText($rawText);

		# Assert
		$this->assertEquals($expected, $actual);
	}

	public function testGetDomainFromUrl(): void
	{
		# Arrange
		$urls = yaml_parse_file("{$this->fixturesPath}/SearchClients/GoogleSearchClientTest/url_to_domain.yaml");
		$expectedDomain = array_key_first($urls);

		# Act
		foreach($urls[$expectedDomain] as $url){
			$actualDomain = Sanitizer::getDomainFromUrl($url);

			# Assert
			$this->assertEquals($actualDomain, $expectedDomain);
		}
	}
}
