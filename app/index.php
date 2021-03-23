<?php

namespace App;

use App\Controller\AbstractController;
use App\Helpers\ParameterStore;
use App\Helpers\Request\Http\CurlRequest;
use App\Helpers\Request\Requests\RequestFactory;
use App\Helpers\Response\Response;
use App\Helpers\Sanitizer;
use App\SearchClients\GoogleApi;
use App\SearchClients\GoogleSearchClient;
use App\SearchClients\SearchClientInterface;
use Exception;

require_once 'vendor/autoload.php';

/**
 * This is the application entrypoint
 */

// Get route from request
$route = getRoute();

// Route the request based on it's path
switch ($route) {
	case 'search_query':
		$controllerName = 'SearchController';
		$actionName = 'searchAction';
		break;

    case '/':
	default:
		$controllerName = 'SearchController';
		$actionName = 'searchFormAction';
		break;
}

// Prepare arguments to be passed to the controller
$parameters = yaml_parse_file(__DIR__ . '/config/config.yaml');
$parameterStore = new ParameterStore($parameters);
$response = new Response(getViewPath($controllerName, $actionName));

// Instantiate the appropriate controller
$controller = createController($controllerName, $response, $parameterStore);

// Prepare search engine config and instantiate the appropriate search client
$searchEngineName = 'google';
$searchApiConfig = buildSearchApiConfig($searchEngineName, $parameterStore);
$searchClient = createSearchClient($searchEngineName, $searchApiConfig, $parameterStore);

// Sanitize the $_POST input and call the appropriate controller action
$sanitizedPostInput = Sanitizer::sanitizeTextArray($_POST);
$viewTemplate = $controller->{$actionName}($sanitizedPostInput, $searchClient);

// The controller returns a rendered view template in HTML, print this HTML view template to user
echo $viewTemplate;


/**
 * Returns the route from current request
 *
 * @return string
 */
function getRoute(): string
{
	// If there is an 'action' url parameter in the request, return it's value
	// This occurs when there's a form submission
	if (isset($_GET['action'])) {
		return $_GET['action'];
	}

	// Return the request path
	return $_SERVER['REQUEST_URI'];
}


/**
 * Instantiates and returns a Controller object
 *
 * @param string $controllerName
 * @param ParameterStore $parameterStore
 * @param Response $response
 * @return AbstractController
 */
function createController(string $controllerName, Response $response, ParameterStore $parameterStore): AbstractController
{
	// Instantiate appropriate controller based on $controllerName
	$qualifiedControllerName = "App\\Controller\\{$controllerName}";
	return new $qualifiedControllerName($response, $parameterStore);
}


/**
 * @param string $controllerName
 * @param string $actionName
 * @return string
 */
function getViewPath(string $controllerName, string $actionName): string
{
	// extract controller name
	$controllerName = str_ireplace('controller', '', strtolower($controllerName));

	// extract action name
	$actionName = str_ireplace('action', '', strtolower($actionName));

	$viewRootDir = __DIR__ . '/src/View';

	return "{$viewRootDir}/{$controllerName}/{$actionName}.template.php";
}


/**
 * @param string $searchEngineName
 * @param ParameterStore $parameterStore
 * @return array
 */
function buildSearchApiConfig(string $searchEngineName, ParameterStore $parameterStore): array
{
	$searchConfig = $parameterStore->getParameter('search_config');

	$apiScheme = $searchConfig[$searchEngineName]['scheme'];
	$apiHost = $searchConfig[$searchEngineName]['host'];
	$apiBasePath = $searchConfig[$searchEngineName]['basepath'];
	$apiKey = $searchConfig[$searchEngineName]['api_key'];
	$apiEndpoint = $apiScheme . '://'. $apiHost . '/' . $apiBasePath;

	return [
		'apiScheme' => $apiScheme,
		'apiHost' => $apiHost,
		'apiBasePath' => $apiBasePath,
		'apiEndpoint' => $apiEndpoint,
		'apiKey' => $apiKey
	];
}


/**
 * Returns a SearchClient based on the search engine
 *
 * @param string $searchEngineName
 * @param array $searchApiConfig
 * @param ParameterStore $parameterStore
 * @return SearchClientInterface|null
 * @throws Exception
 */
function createSearchClient(string $searchEngineName, array $searchApiConfig, ParameterStore $parameterStore): ?SearchClientInterface
{
	switch ($searchEngineName) {
		case 'google':
			// Instantiate GoogleApi Adaptee class
			$http = new CurlRequest();
			$requestClient = RequestFactory::create('GET', $searchApiConfig['apiEndpoint'], $http);
			$googleApi = new GoogleApi($searchApiConfig['apiKey'], $requestClient);

			// Instantiate GoogleSearchClient Adapter class that wraps the GoogleApi Adaptee
			return new GoogleSearchClient($googleApi, $parameterStore);

		default:
			return null;
	}
}
