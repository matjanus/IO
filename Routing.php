<?php

require_once 'src/controllers/DefaultController.php';
require_once 'src/controllers/SecurityController.php';
require_once 'src/controllers/UserController.php';
require_once 'src/controllers/CoursesController.php';
require_once 'src/controllers/ExercisesController.php';
require_once 'src/controllers/PackagesController.php';


class Router {

  public static $routes;

  public static function get($url, $view) {

    self::$routes[$url] = $view;
  }

  public static function post($url, $view) {
    self::$routes[$url] = $view;
  }

  public static function run ($url) {
    $exploded_url = explode("/", $url);
    $action = $exploded_url[0];
    if (!array_key_exists($action, self::$routes)) {
      die("Wrong url! + $action + $url");
    }

    $controller = self::$routes[$action];
    $object = new $controller;
    $action = $action ?: 'index';

    if(count($exploded_url)>1){
      $object->$action($exploded_url);
    }else{
      $object->$action();
    }
    
  }
}