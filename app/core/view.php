<?php
/**
 * Created by Igor Elovskiy [Genbo] > Date 2016-12-14 < PhpStorm 2016.1.2 app/core/view.php
 * Основной "вид" системы получает параметры от конроллера для вывода на экран
 * Конвертирует данные псевдопеременных, работает со строками и массивами
 * Занимается "склейкой" файлов-видов из app/view с обработкой
 */

namespace Core;

class View {

  private $_template;
  private $_vars = array();
  private $_vars_array = array();
  private $_var_array_name = null;
  private $_str = '';

  /**
   * Устанавливает соответствия псевдопеременных
   * @param $name - имя псевдопеременной
   * @param $val - истинное значение
   */
  public function set($name, $val) {

    if (is_array($val)) {
      if ((count($val, COUNT_RECURSIVE)) - count($val) <= 0) {
        $this->_vars_array[$name] = $val;
        $val = '[var ' . $name . ' is ARRAY]';
      }
      else {
        $val = '[var ' . $name . ' is MULTIDIMENSIONAL ARRAY]';
      }
    }
    $this->_vars['{{' . $name . '}}'] = $val;

  }

  /**
   * Производит "внедрение" других файлов в шаблон
   * @param $name - имя псевдопеременной
   * @param $view - файл "склейки"
   */
  public function glue($name, $view) {

    $str = file_get_contents('app/views/' . $view);
    $result = $this->_assignVars($str);
    $this->_vars['{{' . $name . '}}'] = $result;

  }

  /**
   * Отображает данные на экране с предварительной заменой псевдопеременных
   * @param $template - основной шаблон по пути app/views/{template.php}
   * @param bool $isAssign - Включение/выключение подмены
   */
  public function display($template, $isAssign = true) {

    $this->_template = 'app/views/' . $template;
    if (!file_exists($this->_template)) die('Template ' . $this->_template . ' does not exist!');
    $this->_str = file_get_contents($this->_template);
    if ($isAssign === true) {
      $this->_str = $this->_assignVars($this->_str);
      if (count($this->_vars_array) > 0) {
        foreach ($this->_vars_array as $key => $val) {
          $this->_var_array_name = $key;
          $this->_str = $this->_cycleCreate($key);
        }
      }
    }

    echo $this->_str;

  }

  /**
   * Заменяет псевдопеременные на истинные значения
   * @param $str - исходная "сырая" строка
   * @return mixed - обработанные данные
   */
  private function _assignVars($str) {

    $result = str_replace(array_keys($this->_vars), array_values($this->_vars), $str);
    return $result;

  }

  /**
   * Обработка цикла если псевдопеременная - массив
   * @param $key - текущий ключ массива
   * @return mixed|string
   */
  private function _cycleCreate($key) {

    $result = '';
    $re = '~\{\{cycle from ' . $key . '\}\}(.+?)\{\{/cycle\}\}~is';
    if (preg_match($re, $this->_str)) {
      $result = preg_replace_callback($re, array($this, '_cycleCreateReplace'), $this->_str);
    }

    return $result;

  }

  /**
   * Медот заменяет псевдоцикл обычным выводом в цикле
   * @param $matches - найденный совпадения
   * @return string - обработанная строка
   */
  private function _cycleCreateReplace($matches) {

    $txt = '';
    foreach ($this->_vars_array[$this->_var_array_name] as $k => $v) {
      $txt .= str_replace(array('{{key}}', '{{val}}'), array($k, $v), $matches[1]);
    }

    return $txt;
    
  }

}