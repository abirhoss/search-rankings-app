<?php

namespace App\Helpers\Response;


/**
 * Class Response
 */
class Response implements ResponseInterface
{
	private string $viewPath;

	/**
	 * Response constructor.
	 * @param string $viewPath
	 */
	public function __construct(string $viewPath)
	{
		// Set view path
		$this->viewPath = $viewPath;
	}

	/**
	 * Loads a view template based on controller and action names then returns it
	 *
	 * @param array|null $vars
	 * @return string
	 */
	public function renderView(array $vars = null): string
	{
		// Start an output buffer
		ob_start(null, 0, PHP_OUTPUT_HANDLER_CLEANABLE ^ PHP_OUTPUT_HANDLER_REMOVABLE);

		// Load view template from view path
		require $this->viewPath;

		// Return view content from current buffer and delete buffer contents
		return ob_get_clean();
	}
}
