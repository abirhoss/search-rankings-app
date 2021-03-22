<?php


namespace App\Helpers\Request\Http;


interface HttpRequestInterface
{
	public function getInfo(string $name);

	public function setOption(string $name, $value);

	public function execute();

	public function close();

}
