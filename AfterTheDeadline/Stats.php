<?php
/**
 * Class for the stats endpoint
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

class AfterTheDeadline_Stats extends AfterTheDeadline_Common {

  /**
   * Implementation of the get method to get the stats
   *
   * @access public
   * @param $text
   *   A string of text to retreive statistics about.
   * @return
   *   Returns an object from the AfterTheDeadline reponse handler.
   */
  public function get($text) {
    $endpoint = 'stats';
    return $this->send_request($endpoint, $text);
  }
}
