<?php

require 'AfterTheDeadline/Response.php';

abstract class AfterTheDeadline_Common {

  public $lastCall = '';
  public $lastResponse = '';
  public $callInfo = '';

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
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
//    curl_setopt($ch, CURLOPT_VERBOSE, TRUE);

    if (strtoupper($method) == 'POST') {
      curl_setopt($ch, CURLOPT_POST, TRUE);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
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
