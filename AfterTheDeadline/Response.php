<?php

class AfterTheDeadline_Response {
  protected $response = '';

  public function __construct($response) {
    $this->response = $response;
  }

  /**
   * Since the only response After The Deadline returns is XML
   * we will parse only XML
   */
  public function parse() {
    if(!function_exists('simplexml_load_string')) {
      throw new AfterTheDeadline_Exception('simplexml_load_string() not found.');
    }

    $xml = @simplexml_load_string($this->response);
    if(!$xml instanceof SimpleXMLElement) {
      throw new AfterTheDeadline_Exception('Could not parse XML');
    }

    if ((isset($xml['code']) && is_numeric($xml['code'])) &&
       (isset($xml['message']) && strlen($xml['message']))) {
      throw new AfterTheDeadline_Exception((string)$xml['message'], (int)$xml['code']);
    }

    return $xml;
  }
}
