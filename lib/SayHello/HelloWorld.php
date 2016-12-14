<?php
/**
 * Created by Igor Elovskiy [Genbo] > Date 2016-12-14 < PhpStorm 2016.1.2 lib/SayHello/HelloWorld.php
 * Пример, какого-либо староннего класса вне модели MVC - возвращает приветствие
 * Класс также подключается автоматически при его объявлении
 */

namespace Lib\SayHello;

class HelloWorld {

  public function __construct() {
   // not use
  }

  public function sayHello() {
    return 'hello world!';
  }

}