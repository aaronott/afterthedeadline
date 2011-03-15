<?php
/**
 * Tests AfterTheDeadline_Stats class
 *
 * @group AfterTheDeadline
 *
 * @package AfterTheDeadline
 * @author  Aaron Ott <aaron.ott@gmail.com>
 * @copyright 2011 Aaron Ott
 */

require_once 'AfterTheDeadline.php';
require_once 'AfterTheDeadline/Common.php';
require_once 'AfterTheDeadline/Stats.php';

class AfterTheDeadline_StatsTest extends PHPUnit_Framework_TestCase
{
  protected $Stats;

  public function setUp() {
    $this->Stats = AfterTheDeadline::factory('Stats');
  }

  /**
   * @group afterthedark
   * @group stats
   */
  public function testStats() {
    $testFile = 'Tests/texts/grammar';
    $text = file_get_contents($testFile);

    $stats = $this->Stats->get($text);
    $this->assertSame(6, (int)$stats->metric[0]->value);
    $this->assertSame('grammar', (string)$stats->metric[0]->type);
    $this->assertSame('errors', (string)$stats->metric[0]->key);
  }

  /**
   * @group afterthedark
   * @group stats
   */
  public function testStatsSpelling() {
    $testFile = 'Tests/texts/speller';
    $text = file_get_contents($testFile);

    $stats = $this->Stats->get($text);
    $this->assertSame(1, (int)$stats->metric[0]->value);
    $this->assertSame('spell', (string)$stats->metric[0]->type);
    $this->assertSame('hyphenate', (string)$stats->metric[0]->key);
  }
}
