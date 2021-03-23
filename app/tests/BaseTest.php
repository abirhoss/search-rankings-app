<?php


use App\Helpers\ParameterStore;
use PHPUnit\Framework\TestCase;

abstract class BaseTest extends TestCase
{
	protected string $fixturesPath;

	protected ParameterStore $parameterStore;

	protected function setUp(): void
	{
		$parameters = yaml_parse_file(__DIR__ . '/test_config.yaml');
		$this->parameterStore = new ParameterStore($parameters);
		$this->fixturesPath = __DIR__ . '/fixtures';
	}

	/**
	 * @return string
	 */
	public function getFixturesPath(): string
	{
		return $this->fixturesPath;
	}

	/**
	 * @param string $fixturesPath
	 * @return BaseTest
	 */
	public function setFixturesPath(string $fixturesPath): BaseTest
	{
		$this->fixturesPath = $fixturesPath;
		return $this;
	}

	/**
	 * @return ParameterStore
	 */
	public function getParameterStore(): ParameterStore
	{
		return $this->parameterStore;
	}

	/**
	 * @param ParameterStore $parameterStore
	 * @return BaseTest
	 */
	public function setParameterStore(ParameterStore $parameterStore): BaseTest
	{
		$this->parameterStore = $parameterStore;
		return $this;
	}
}
