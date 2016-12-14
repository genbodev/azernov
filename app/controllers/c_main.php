<?php
/**
 * Created by Igor Elovskiy [Genbo] > Date 2016-12-14 < PhpStorm 2016.1.2 app/controllers/c_main.php
 * Класс Core\CMain расширяет основной класс Core\Controller и является контроллером main page
 * Данный контроллер отрабатывает, когда пользователь запрашивает главную страницу сайта
 */
namespace Core;

use Lib\SayHello as SayHello;

class CMain extends Controller {

  /**
   * Метод передает в "вид" псевдопеременные и ее значение
   * set title - название текущей страницы, тег title
   * glue content - подключение в "вид" файла
   * set site - название хоста сайта
   * glue link - файл с 2 ссылками
   * display - вывод на экран
   */
  public function index() {

    // Пример работы со сторонними библиотеками
    $obj = new SayHello\HelloWorld;

    $this->view->set('title', 'Main Page');
    $this->view->set('hello', ' - ' . $obj->sayHello()); // Метод стороннего класса
    $this->view->glue('content', 'content.php');
    $this->view->set('site', $_SERVER['HTTP_HOST']);
    $this->view->glue('links', 'links.php');
    $this->view->display('index.php');

  }

}