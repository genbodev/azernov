<?php

/**
 * Created by Igor Elovskiy [Genbo] > Date 2016-12-14 < PhpStorm 2016.1.2 app/core/route.php
 * Класс маршрутизации наполняется маршрутами вручную в свойство класса $routes
 * В зависимости от запрашиваемого URL вызывает нужный контроллер и модель
 */
class Route {

  private static $routes = array(

    array(
      'pattern' => '~^/$~',
      'module' => 'main',
      'method' => 'index'
    ),

    array(
      'pattern' => '~^/user/([0-9]+)$~',
      'module' => 'users',
      'method' => 'index',
      'params' => array('user_id')
    ),

  );

  /**
   * Метод парсит запрашиваемый URL и ищет совпадения в заданых маршрутах $routes
   * При найденом совпадении получает название "модуля" и "экшен"
   * Ищет и подключает контроллер, используя префикс c_
   * Ищет и подключает модель, используя префикс m_
   * Вызывает контроллер и передает параметры
   * Вызывает "экшен" контроллера
   */
  public static function init() {

    $module = null;
    $action = 'index';
    $params = array();

    $url_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    foreach (self::$routes as $map) {
      if (preg_match($map['pattern'], $url_path, $matches)) {

        array_shift($matches);

        foreach ($matches as $key => $val) {
          $params[$map['params'][$key]] = $val;
        }

        $module = $map['module'];
        $action = $map['method'];

        break;
      }
    }

    if (!is_null($module)) {
      $path_model = 'app' . DS . 'models' . DS . 'm_' . $module . '.php';
      $path_controller = 'app' . DS . 'controllers' . DS . 'c_' . $module . '.php';

      if (file_exists($path_model)) {
        include $path_model;
      }

      if (file_exists($path_controller)) {
        include $path_controller;
      }
      else {
        self::show404();
      }

      $controller_name = 'Core\C' . ucfirst($module);
      $controller = new $controller_name($params);

      if (method_exists($controller, $action)) {
        $controller->$action();
      }
      else {
        self::show404();
      }
    }
    else {
      self::show404();
    }

  }

  /**
   * Условная ошибка страница-404, если:
   * не найден маршрут для URL
   * не найден контроллер
   * не найдена "экшен"
   */
  private static function show404() {

    $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
    header('HTTP/1.1 404 Not Found');
    header("Status: 404 Not Found");
    header('Location:' . $host . '404');

  }

}