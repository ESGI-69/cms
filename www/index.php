<?php

namespace App;

use App\Core\AuthManager;

require "conf.inc.php";

session_start();

function myAutoloader($class)
{
  // $class => CleanWords
  $class = str_replace("App\\", "", $class);
  $class = str_replace("\\", "/", $class);
  if (file_exists($class . ".class.php")) {
    include $class . ".class.php";
  }
}

spl_autoload_register("App\myAutoloader");

/**
 * @var string Contient la route avec les argurments enlevés
 *
 * e.g. `/verify?t=ABC` => `verify`
 */
$uri = null;
if (strpos($_SERVER["REQUEST_URI"], "?")) {
  $uri = substr($_SERVER["REQUEST_URI"], 0, strpos($_SERVER["REQUEST_URI"], "?"));
} else {
  $uri = $_SERVER["REQUEST_URI"];
}

$routeFile = "routes.yml";
if (!file_exists($routeFile)) {
  die("Le fichier " . $routeFile . " n'existe pas");
}

$routes = yaml_parse_file($routeFile);

$controller = null;
$action = null;
$explodedUri = explode('/', $uri);

// Si url est sur la homepage
if ($uri === '/') {
  if (empty($routes[$uri]) || empty($routes[$uri]["controller"]) || empty($routes[$uri]["action"])) {
    die('404 Not found<br><img src="https://http.cat/404" alt="cat 404 http error" />');
  }
  $controller = ucfirst(strtolower($routes[$uri]["controller"]));
  $action = strtolower($routes[$uri]["action"]);
  // Si c'est une route simple
} elseif (count($explodedUri) === 2) {
  if (
    empty($routes[$uri])
    || empty($routes[$uri]["controller"])
    || empty($routes[$uri]["action"])
  ) {
    die('404 Not found<br><img src="https://http.cat/404 " alt="cat 404 http error" />');
  } else if (isset($routes[$uri]["security"]) ? AuthManager::checkPermission($routes[$uri]["security"]) : true) {
    $controller = ucfirst(strtolower($routes[$uri]["controller"]));
    $action = strtolower($routes[$uri]["action"]);
  } else {
    die('403 Forbidden<br><img src="https://http.cat/403" alt="cat 403 http error" />');
  }
  // Si c'est une route qui tape sur un enfant (c'est pas bien)
} elseif (count($explodedUri) === 3) {
  if (
    empty($routes['/' . $explodedUri[1]]['childrens']['/' . $explodedUri[2]])
    || empty($routes['/' . $explodedUri[1]]['childrens']['/' . $explodedUri[2]]["controller"])
    || empty($routes['/' . $explodedUri[1]]['childrens']['/' . $explodedUri[2]]["action"])
  ) {
    die('404 Not found<br><img src="https://http.cat/404 alt="cat 404 http error"" />');
  } else if (isset($routes['/' . $explodedUri[1]]["security"]) ? AuthManager::checkPermission($routes['/' . $explodedUri[1]]["security"]) : true) {
    $controller = ucfirst(strtolower($routes['/' . $explodedUri[1]]['childrens']['/' . $explodedUri[2]]["controller"]));
    $action = strtolower($routes['/' . $explodedUri[1]]['childrens']['/' . $explodedUri[2]]["action"]);
  } else {
    die('403 Forbidden<br><img src="https://http.cat/403" alt="cat 403 http error" />');
  }
  // Si c'est une route qui a trop d'enfant (?)
} else {
  die('404 Not found<br><img src="https://http.cat/404" alt="cat 404 http error" />');
}

/*
 *
 *  Vérfification de la sécurité, est-ce que la route possède le paramètr security
 *  Si oui est-ce que l'utilisation a les droits et surtout est-ce qu'il est connecté ?
 *  Sinon rediriger vers la home ou la page de login
 *
 */

$controllerFile = "Controller/" . $controller . ".class.php";
if (!file_exists($controllerFile)) {
  die("Le controller " . $controllerFile . " n'existe pas");
}
//Dans l'idée on doit faire un require parce vital au fonctionnement
//Mais comme on fait vérification avant du fichier le include est plus rapide a executer
include $controllerFile;

$controller = "App\\Controller\\" . $controller;
if (!class_exists($controller)) {
  die("La classe " . $controller . " n'existe pas");
}
// $controller = User ou $controller = Global
$objectController = new $controller();

if (!method_exists($objectController, $action)) {
  die("L'action " . $action . " n'existe pas");
}
// $action = login ou logout ou register ou home
$objectController->$action();

//Crée un dossier user-media si il n'existe pas
if (!file_exists("user-media")) {
  mkdir("user-media");
}
