<?php

namespace App\Helpers\Response;


/**
 * Interface ResponseInterface
 */
interface ResponseInterface
{
	/**
	 * @param array $vars
	 * @return string
	 */
	public function renderView(array $vars): string;
}
