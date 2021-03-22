<?php

namespace App\Controller;


use App\SearchClients\GoogleSearchClient;

/**
 * Interface ControllerInterface
 */
interface ControllerInterface
{
	/**
	 * @return string
	 */
	public function searchFormAction(): string;

	/**
	 * @param array $searchFormInput
	 * @param GoogleSearchClient $searchClient
	 * @return string
	 */
	public function searchAction(array $searchFormInput, GoogleSearchClient $searchClient): string;
}
