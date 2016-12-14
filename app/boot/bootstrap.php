<?php
/**
 * Created by Igor Elovskiy [Genbo] > Date 2016-12-14 < PhpStorm 2016.1.2 app/boot/bootstrap.php
 * Первичное подключение файлов php для инициализации констант, MVC модели и маршрутизации:
 * defines.php - хранение констант, например, данные для подключения к БД или другие
 * classloader.php - автозагрузка классов через стандартную библиотеку SPL
 * route.php - файл php для построения маршрутов из URL запросов
 * controller.php - основной контроллер ядра системы
 * model.php - основная модель ядра системы
 * view.php - основной "вид" ядра
 */

require_once 'app' . DIRECTORY_SEPARATOR . 'boot' . DIRECTORY_SEPARATOR . 'defines.php';
require_once 'app' . DS . 'core' . DS . 'classloader.php';
require_once 'app' . DS . 'core' . DS . 'route.php';
require_once 'app' . DS . 'core' . DS . 'controller.php';
require_once 'app' . DS . 'core' . DS . 'model.php';
require_once 'app' . DS . 'core' . DS . 'view.php';

Route::init();