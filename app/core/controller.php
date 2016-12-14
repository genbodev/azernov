<?php
/**
 * Created by Igor Elovskiy [Genbo] > Date 2016-12-14 < PhpStorm 2016.1.2 app/core/controller.php
 * Основной контроллер системы получает параметры от роутера и вызывает основной "вид"
 */

namespace Core;

class Controller {

  public $model;
  public $view;
  protected $params;

  public function __construct($params) {

    $this->params = $params;
    $this->view = new View();
    
  }

  public function index() {
    // not use
  }

}
