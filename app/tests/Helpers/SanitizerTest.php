<?php declare(strict_types=1);

namespace App\Tests;


use App\Helpers\Sanitizer;
use PHPUnit\Framework\TestCase;


final class SanitizerTest extends TestCase
{
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
}
