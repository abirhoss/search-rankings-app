<?php


namespace App\Helpers\Request\Http;


/**
 * Class CurlRequest
 * @package App\Helpers\Request\Http
 */
class CurlRequest implements HttpRequestInterface
{

	public $curlSession;

	/**
	 * CurlRequest constructor.
	 */
	public function __construct()
	{
		$this->curlSession = curl_init();
	}

	/**
	 * @param string $name
	 * @return mixed
	 */
	public function getInfo(string $name)
	{
		return curl_getinfo($this->curlSession);
	}

	/**
	 * @param string $name
	 * @param $value
	 * @return mixed|void
	 */
	public function setOption(string $name, $value)
	{
		curl_setopt($this->curlSession, $name, $value);
	}

	/**
	 * @return bool|mixed|string
	 */
	public function execute()
	{
		return curl_exec($this->curlSession);
	}

	/**
	 * @return mixed|void
	 */
	public function close()
	{
		curl_close($this->curlSession);
	}
}
