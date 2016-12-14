<?php
/**
 * Created by Igor Elovskiy [Genbo] > Date 2016-12-14 < PhpStorm 2016.1.2 app/controllers/c_users.php
 * Класс Core\CUsers расширяет основной класс Core\Controller и является контроллером users page
 * Данный контроллер отрабатывает, когда пользователь запрашивает url {site}/user/{id}
 */
namespace Core;

class CUsers extends Controller {

  /**
   * Метод инициализирует работу модели MUsers и передает в "вид" псевдопеременные и ее значение
   * Вызывает модель MUsers, передает ей данные для подключения к разным базам данных
   * Модель возвращает результат в виде массива, который содержит пользователей
   * Контроллер поочередно передает в "вид" данные для вывода на экран
   * set title - название текущей страницы, тег html <title>
   * glue content - подключение в "вид" файла user.php
   * set user - передача в "вид" запрашиваемый id
   * set user_arr - данные пользователя
   * set user1..2..3..4 - остальные
   * glue links - склейка ссылок
   * display - вывод на экран
   */
  public function index() {

    $config = array(
      'db1' => array(
        'host' => 'sql7.freemysqlhosting.net',
        'user' => 'sql7149148',
        'password' => 'CzHzeJ9R3u',
        'database' => 'sql7149148',
      ),
      'db2' => array(
        'host' => 'localhost',
        'user' => 'cq29882_azernov',
        'password' => 'rQwSxUgM',
        'database' => 'cq29882_azernov',
      )
    );

    $this->model = new MUsers();
    $users = $this->model->getUsers($config);
    $user = $users['db1'][$this->params['user_id']];

    $this->view->set('title', 'Users Page');
    $this->view->set('hello', ''); // Глушит псевдопеременную
    $this->view->glue('content', 'user.php');
    $this->view->set('user', 'User: ' . $this->params['user_id']);
    $this->view->set('user_arr', $user);
    $this->view->set('user1', $users['db1'][1]['first_name'] . ' ' . $users['db1'][1]['second_name']);
    $this->view->set('user2', $users['db1'][2]['first_name'] . ' ' . $users['db1'][2]['second_name']);
    $this->view->set('user3', $users['db2'][1]['first_name'] . ' ' . $users['db2'][1]['second_name']);
    $this->view->set('user4', $users['db2'][2]['first_name'] . ' ' . $users['db2'][2]['second_name']);
    $this->view->set('site', $_SERVER['HTTP_HOST']);
    $this->view->glue('links', 'links.php');
    $this->view->display('index.php');
    
  }

}