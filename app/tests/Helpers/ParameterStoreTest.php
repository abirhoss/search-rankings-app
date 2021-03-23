<?php declare(strict_types=1);

namespace App\Tests\Helpers;


use App\Helpers\ParameterStore;
use PHPUnit\Framework\TestCase;


final class ParameterStoreTest extends TestCase
{
	private ParameterStore $parameterStore;

	protected function setUp(): void
	{
		$dummyParameters = [
			'name' => 'value'
		];

		$this->parameterStore = new ParameterStore($dummyParameters);
	}

	public function testGetParameter(): void
	{
		# Arrange
		$expectedParameterValue = 'value';

		# Act
		$actualParameterValue = $this->parameterStore->getParameter('name');

		# Assert
		$this->assertEquals($expectedParameterValue, $actualParameterValue);
	}

	public function testSetParameter(): void
	{
		# Arrange
		$parameterName = 'name';
		$parameterValue = 'value';

		# Act
		$this->parameterStore->setParameter($parameterName, $parameterValue);

		# Assert
		$actualParameterValue = $this->parameterStore->getParameter($parameterName);
		$this->assertEquals($parameterValue, $actualParameterValue);
	}
}
