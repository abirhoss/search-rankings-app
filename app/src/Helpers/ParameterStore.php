<?php


namespace App\Helpers;


/**
 * Class ParameterStore
 * @package App\Helpers
 */
class ParameterStore
{
	private array $parameters;

	/**
	 * ParameterStore constructor.
	 * @param array $parameters
	 */
	public function __construct(array $parameters)
	{
		$this->parameters = $parameters;
	}

	/**
	 * @param string $name
	 * @return mixed|null
	 */
	public function getParameter(string $name)
	{
		if(!isset($this->parameters[$name])){
			return null;
		}

		return $this->parameters[$name];
	}

	/**
	 * @return array
	 */
	public function getParameters(): array
	{
		return $this->parameters;
	}

	/**
	 * @param string $name
	 * @param $value
	 * @return ParameterStore
	 */
	public function setParameter(string $name, $value): ParameterStore
	{
		$this->parameters[$name] = $value;
		return $this;
	}

	/**
	 * @param array $parameters
	 * @return ParameterStore
	 */
	public function setParameters(array $parameters): ParameterStore
	{
		$this->parameters = $parameters;
		return $this;
	}
}
