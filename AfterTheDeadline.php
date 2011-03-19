<?php
/**
 * API implementation for After the Deadline's web service
 *
 * PHP version 5.1.0+
 *
 * LICENSE: This source file is subject to the New BSD license that is 
 * available through the world-wide-web at the following URI:
 * http://www.opensource.org/licenses/bsd-license.php. If you did not receive  
 * a copy of the New BSD License and are unable to obtain it through the web, 
 * please send a note to license@php.net so we can mail you a copy immediately.
 *
 * @package     AfterTheDeadline
 * @author      Aaron Ott <aaron.ott@gmail.com> 
 * @copyright   2011 Aaron Ott
 * @link        http://www.afterthedeadline.com/development.slp
 */ 

$basepath = realpath(dirname(__FILE__));
require_once $basepath . '/AfterTheDeadline/Exception.php';
require_once $basepath . '/AfterTheDeadline/Common.php';

abstract class AfterTheDeadline {

  /**
   * The URL to the AtD Service
   * (no trailing slashes)
   */
  public static $uri = 'http://service.afterthedeadline.com';

  /**
   * AtD used to require users to register for an API key. They no longer do this
   * but applications are still required to submit an API key. The API key is
   * used as both a synchronous locking point (e.g., only one request/key is
   * processed at a time) and to enable server-side caching of results and
   * session information. This makes subsequent requests for the same key much
   * faster.
   *
   * @link http://www.afterthedeadline.com/api.slp
   */
  public static $key = 'AfterTheDeadline';

  /**
   * The factory method for loading the right files.
   */
  public function factory($endPoint) {
    $basepath = realpath(dirname(__FILE__));
    $file = 'AfterTheDeadline/' . $endPoint . '.php';
    if (!include_once($basepath . '/' . $file)) {
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
