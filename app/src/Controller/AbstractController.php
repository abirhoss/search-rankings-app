<?php


namespace App\Controller;


use App\Helpers\ParameterStore;
use App\Helpers\Response\Response;


/**
 * Class AbstractController
 * @package App\Controller
 */
abstract class AbstractController
{
	protected Response $response;
	protected ParameterStore $parameterStore;

	/**
	 * AbstractController constructor.
	 * @param Response $response
	 * @param ParameterStore $parameterStore
	 */
	public function __construct(Response $response, ParameterStore $parameterStore)
	{
		$this->response = $response;
		$this->parameterStore = $parameterStore;
	}
}
