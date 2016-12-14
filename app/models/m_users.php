<?php
/**
 * Created by Igor Elovskiy [Genbo] > Date 2016-12-14 < PhpStorm 2016.1.2 app/core/m_users.php
 * Модель для работы с пользователями: запросы и обработка полученных данных
 * Работает в паре с контроллером CUsers - получает парамеры для БД
 */

namespace Core;

class MUsers extends Model {

  /**
   * Создает ресурс для подключения к БД
   * @param null $config
   * @return \mysqli
   */
  public function getResourceBD($config = null) {

    if (is_null($config)) {
      $config['host'] = HOST;
      $config['user'] = USER;
      $config['password'] = PASSWORD;
      $config['database'] = DATABASE;
    }

    $resource = mysqli_connect($config['host'], $config['user'], $config['password'],
      $config['database']) or die('Error ' . mysqli_error($resource));
    
    return $resource;

  }

  /**
   * Получет конфигурации для подключения к БД
   * Получает пользователей из БД
   * Возвращает пользователей
   * @param $config
   * @return array
   */
  public function getUsers($config) {

    $users = array();

    $mysqli = $this->getResourceBD($config['db1']);

    $sql = "SELECT id, first_name, second_name FROM users";
    $mysqli->set_charset("utf8");
    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $first_name, $second_name);
    if ($stmt->num_rows > 0) {
      while ($stmt->fetch()) {
        $users['db1'][$id] = array('first_name' => $first_name, 'second_name' => $second_name);
      }
    }
    $stmt->close();

    $mysqli = $this->getResourceBD($config['db2']);

    $sql = "SELECT id, first_name, second_name FROM users";
    $mysqli->set_charset("utf8");
    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $first_name, $second_name);
    if ($stmt->num_rows > 0) {
      while ($stmt->fetch()) {
        $users['db2'][$id] = array('first_name' => $first_name, 'second_name' => $second_name);
      }
    }
    $stmt->close();

    return $users;

  }
}