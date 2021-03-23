<?php declare(strict_types=1);

namespace App\Tests\Helpers;


use App\Helpers\Sanitizer;
use BaseTest;


final class SanitizerTest extends BaseTest
{
	public function testSanitizeTextArray(): void
	{
		# Arrange
		$badTextArray = [
			'searchKeywords' => "<script\\x20type=\"text/javascript\">javascript:alert(1);</script>",
			'url' => "\"><script>alert(123);</script x=\""
		];

		$expectedSanitizedArray = [
			'searchKeywords' => 'javascript:alert(1);',
			'url' => '&#34;>alert(123);',
		];

		# Act
		$actualTextArray = Sanitizer::sanitizeTextArray($badTextArray);

		# Assert
		$this->assertEquals($expectedSanitizedArray, $actualTextArray);
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
