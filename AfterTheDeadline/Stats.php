<?php

class AfterTheDeadline_Stats extends AfterTheDeadline_Common {
  public function get($text) {
    $endpoint = 'stats';
    return $this->send_request($endpoint, $text);
  }
}
