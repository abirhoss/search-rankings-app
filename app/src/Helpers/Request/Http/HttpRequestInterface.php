<?php


namespace App\Helpers\Request\Http;


/**
 * Interface HttpRequestInterface
 * @package App\Helpers\Request\Http
 */
interface HttpRequestInterface
{
	/**
	 * @param string $name
	 * @return mixed
	 */
	public function getInfo(string $name);

	/**
	 * @param string $name
	 * @param $value
	 * @return mixed
	 */
	public function setOption(string $name, $value);

	/**
	 * @return mixed
	 */
	public function execute();

	/**
	 * @return mixed
	 */
	public function close();

}
