<?php


namespace App\Controller;


use App\Helpers\Response\Response;


/**
 * Class AbstractController
 * @package App\Controller
 */
abstract class AbstractController
{
	protected Response $response;

	/**
	 * AbstractController constructor.
	 * @param Response $response
	 */
	public function __construct(Response $response)
	{
		$this->response = $response;
	}
}
