<?php
/**
 * Created by Igor Elovskiy [Genbo] > Date 2016-12-14 < PhpStorm 2016.1.2 app/core/classloader.php
 * Файл гарантирует автозагрузку классов через стандартную функцию spl_autoload_register
 */

/**
 * @param $className - запрашиваемое имя класса
 * Разбивает имя класса на "кусочки"
 * Собирает путь для подключения
 * Затем подключает php файл
 */
function classLoader($className) {

  $class_pieces = explode('\\', $className);

  switch (strtolower($class_pieces[0])) {

    case 'core':
      require 'app' . DS . strtolower($class_pieces[0]) . DS . strtolower($class_pieces[1]) . '.php';
      break;
    case 'lib':
      require strtolower($class_pieces[0]) . DS . $class_pieces[1] . DS . $class_pieces[2] . '.php';
      break;
    default:
      break;

  }

}

spl_autoload_register('classLoader');