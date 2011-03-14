<?php

require_once 'AfterTheDeadline/Exception.php';
abstract class AfterTheDeadline {

  public static $uri = 'http://service.afterthedeadline.com';
  public static $key = 'AfterTheDeadline';

  public function factory($endPoint) {
    $file = 'AfterTheDeadline/' . $endPoint . '.php';
    if (!include_once($file)) {
      throw new AfterTheDeadline_Exception('Endpoint file not found: ' . $file);
    }

    $class = 'AfterTheDeadline_' . $endPoint;
    if (!class_exists($class)) {
      throw new AfterTheDeadline_Exception('Endpoint class not found: ' . $class);
    }

    $instance = new $class();
    return $instance;
  }
}
