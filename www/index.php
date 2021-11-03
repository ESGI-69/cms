<?php

// Split parameters and put them in an array
$params = explode('/', $_GET['p']);

// if 1 parameters exist 
if ($params[0] != "") {
  // Save first parameter in $routeName
  $routeName = '/'.$params[0];
// else return '/' in $routeName
} else {
  $routeName = '/';
}

// Array of supported routes
$routes = yaml_parse_file('routes.yml', -1)[0];

// Name of the controler;
$controlerFilename;

/**
 * Check if the route is defined in routes.yml
 * If it is, execute the action method
 * If is not, send a 404 page
 */
if (isset($routes[$routeName])) {
  // Contain all the possible route
  $routeArray = $routes[$routeName];

  // Controller file name to execute the method
  $controlerFilename = ucfirst($routeArray['controller'].'.class.php');

  // Contain the route controller
  $controllerName = ucfirst($routeArray['controller']);

  // Contain the route action
  $action = $routeArray['action'];

  // import the concerned controller
  require_once("controllers/$controlerFilename");

  // Instantiate the controller 
  $controller = new $controllerName();

  // Execute the controller method
  $controller->$action();
} else {
  // Send a http 404 reponse code
  http_response_code(404);
  echo '404';
  die();
}
