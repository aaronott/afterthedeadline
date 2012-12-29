<?php
/**
 * Common class used for After The Deadline endpoints
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
require_once $basepath . '/Response.php';

abstract class AfterTheDeadline_Common {

  /**
   * Last API URI called.
   *
   * @access public
   * @var string $lastCall
   */
  public $lastCall = '';

  /**
   * A string containing the response from the last API call.
   *
   * @access public
   * @var string $lastResponse
   */
  public $lastResponse = '';

  /**
   * An associative array containing quite a bit of useful information
   * that can be used while debugging issues.
   *
   * @access public
   * @var array $callInfo
   */
  public $callInfo = '';

  /**
   * Send a request to the API.
   *
   * @access protected
   * @param $endPoint
   *   A string containing the endpoint for where the data is headed
   *   currently After The Deadline supports checkDocument, checkGrammar
   *   and stats
   * @param $text
   *   The text to be checked by After The Deadline
   * @param $method
   *   The method used to send the information.  This currently defaults
   *   to the GET method but may change once the bugs are worked out ot the
   *   POST method.
   * @TODO
   *   Need to fix the POST method here.  Currently the API will only work
   *   with the GET method which severly limits the size of the text that
   *   can be sent at one time
   */
  protected function send_request($endPoint, $text, $method='GET') {
    $uri = AfterTheDeadline::$uri . '/' . $endPoint;
    $data = array(
      'key' => AfterTheDeadline::$key,
      'data' => $text
    );

    if (strtoupper($method) == 'GET') {
      $params = array();
      foreach ($data as $key => $val) {
        $params[] = $key . '=' . urlencode($val);
      }
      $uri .= '?' . implode('&', $params);
    }

    $this->lastCall = $uri;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $uri);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    //curl_setopt($ch, CURLOPT_VERBOSE, TRUE);

    if (strtoupper($method) == 'POST') {
      curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
      curl_setopt($ch, CURLOPT_POST, TRUE);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      print_r($data);
    }

    $this->lastResponse = curl_exec($ch);
    $this->callInfo = curl_getinfo($ch);

    if ($this->lastResponse === FALSE) {
      throw new AfterTheDeadline_Exception('Curl error: ' . curl_error($ch), curl_errno($ch));
    }

    curl_close($ch);

    $response = new AfterTheDeadline_Response($this->lastResponse);
    return $response->parse();
  }
}
