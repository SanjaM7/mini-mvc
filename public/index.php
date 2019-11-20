<?php

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\Router;
use Illuminate\Routing\UrlGenerator;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
/**
 * MINI - an extremely simple naked PHP application
 *
 * @package mini
 * @author Panique
 * @link https://github.com/panique/mini/
 * @license http://opensource.org/licenses/MIT MIT License
 */

// TODO get rid of this and work with namespaces + composer's autoloader

// set a constant that holds the project's folder path, like "/var/www/".
// DIRECTORY_SEPARATOR adds a slash to the end of the path
define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);

// set a constant that holds the project's "application" folder, like "/var/www/application".
define('APP', ROOT . 'application' . DIRECTORY_SEPARATOR);

// This is the (totally optional) auto-loader for Composer-dependencies (to load tools into your project).
// If you have no idea what this means: Don't worry, you don't need it, simply leave it like it is.
if (file_exists(ROOT . 'vendor/autoload.php')) {
    $loader = require ROOT . 'vendor/autoload.php';
}

// load application config (error reporting etc.)
require ROOT . 'config/config.php';

// FOR DEVELOPMENT: this loads PDO-debug, a simple function that shows the SQL query (when using PDO).
// If you want to load pdoDebug via Composer, then have a look here: https://github.com/panique/pdo-debug
require APP . 'Libs/Helper.php';

// Create a service container
$container = new Container;
// Create a request from server variables, and bind it to the container; optional
$request = Request::capture();
$container->instance('Illuminate\Http\Request', $request);
// Using Illuminate/Events/Dispatcher here (not required); any implementation of
// Illuminate/Contracts/Event/Dispatcher is acceptable
$events = new Dispatcher($container);

// Create the router instance
$router = new Router($events, $container);

// Load the routes
require_once ROOT . 'routes/routes.php';
// Create the redirect instance
$redirect = new Redirector(new UrlGenerator($router->getRoutes(), $request));

// Dispatch the request through the router
$response = $router->dispatch($request);
// Send the response back to the browser
$response->send();

