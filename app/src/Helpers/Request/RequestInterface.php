<?php


namespace App\Helpers\Request;


interface RequestInterface
{

	/**
	 * Send the request
	 * @return string
	 */
	public function send(): string;

}
