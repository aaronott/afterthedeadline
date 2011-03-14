<?php

require 'AfterTheDeadline.php';
require 'AfterTheDeadline/Common.php';
require 'AfterTheDeadline/Stats.php';

class AfterTheDeadline_StatsTest extends PHPUnit_Framework_TestCase
{
  protected $Stats;

  public function setUp() {
    $this->Stats = AfterTheDeadline::factory('Stats');
  }

  public function testStats() {
    $testFile = 'Tests/texts/grammar';
    $text = file_get_contents($testFile);

    $stats = $this->Stats->get($text);
    $this->assertSame(6, (int)$stats->metric[0]->value);
    $this->assertSame('grammar', (string)$stats->metric[0]->type);
    $this->assertSame('errors', (string)$stats->metric[0]->key);
  }
}
