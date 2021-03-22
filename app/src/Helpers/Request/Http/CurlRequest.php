<?php


namespace App\Helpers\Request\Http;


/**
 * Class CurlRequest
 * @package App\Helpers\Request\Http
 */
class CurlRequest implements HttpRequestInterface
{
	public $curlSession;

	public function __construct()
	{
		$this->curlSession = curl_init();
	}

	public function getInfo(string $name)
	{
		return curl_getinfo($this->curlSession);
	}

	public function setOption(string $name, $value)
	{
		curl_setopt($this->curlSession, $name, $value);
	}

	public function execute()
	{
		return curl_exec($this->curlSession);
	}

	public function close()
	{
		curl_close($this->curlSession);
	}
}
