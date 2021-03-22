<?php

namespace App;

use App\Controller\AbstractController;
use App\Helpers\Request\Http\CurlRequest;
use App\Helpers\Request\Requests\RequestFactory;
use App\Helpers\Response\Response;
use App\SearchClients\GoogleApi;
use App\SearchClients\GoogleSearchClient;
use App\SearchClients\SearchClientInterface;
use Exception;

require_once 'vendor/autoload.php';

/**
 * This is the application entrypoint
 */

// Load application config and provide it globally
$GLOBALS['config'] = yaml_parse_file(__DIR__ . '/config/config.yaml');

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

// Get controller
$controller = getController($controllerName, $actionName);

// Get search client
$searchClient = getSearchClient('google');

// Call the appropriate controller action. Inject search client into controller as a dependency.
// The controller returns a rendered view template in HTML
$viewTemplate = $controller->{$actionName}($_POST, $searchClient);

// Print HTML view template to user
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
 * @param string $actionName
 * @return AbstractController
 */
function getController(string $controllerName, string $actionName): AbstractController
{
	// Instantiate Response object and inject into controller as a dependency
	$viewPath = getViewPath($controllerName, $actionName);
	$response = new Response($viewPath);

	// Instantiate appropriate controller based on $controllerName
	$qualifiedControllerName = "App\\Controller\\{$controllerName}";
	return new $qualifiedControllerName($response);
}


/**
 * Returns a SearchClient based on the search engine
 *
 * @param string $searchEngine
 * @return SearchClientInterface|null
 * @throws Exception
 */
function getSearchClient(string $searchEngine): ?SearchClientInterface
{
	switch ($searchEngine) {
		case 'google':
			// Prepare search api config
			$searchApiConfig = getSearchApiConfig($searchEngine);

			// Instantiate GoogleApi Adaptee class
			$http = new CurlRequest();
			$requestClient = RequestFactory::create('GET', $searchApiConfig['apiEndpoint'], $http);
			$googleApi = new GoogleApi($searchApiConfig['apiKey'], $requestClient);

			// Instantiate GoogleSearchClient Adapter class that wraps the GoogleApi Adaptee
			return new GoogleSearchClient($googleApi);

		default:
			return null;
	}
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
 * @param string $searchEngine
 * @return array
 */
function getSearchApiConfig(string $searchEngine): array
{
	$apiScheme = $GLOBALS['config']['search_params'][$searchEngine]['scheme'];
	$apiHost = $GLOBALS['config']['search_params'][$searchEngine]['host'];
	$apiBasePath = $GLOBALS['config']['search_params'][$searchEngine]['basepath'];
	$apiKey = $GLOBALS['config']['search_params'][$searchEngine]['api_key'];
	$apiEndpoint = $apiScheme . '://'. $apiHost . '/' . $apiBasePath;

	return [
		'apiScheme' => $apiScheme,
		'apiHost' => $apiHost,
		'apiBasePath' => $apiBasePath,
		'apiEndpoint' => $apiEndpoint,
		'apiKey' => $apiKey
	];
}
