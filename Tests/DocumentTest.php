<?php
/**
 * Tests AfterTheDeadline_Document class
 *
 * @group AfterTheDeadline
 *
 * @package AfterTheDeadline
 * @author  Aaron Ott <aaron.ott@gmail.com>
 * @copyright 2011 Aaron Ott
 */

require_once 'AfterTheDeadline.php';
require_once 'AfterTheDeadline/Common.php';
require_once 'AfterTheDeadline/Document.php';

class AfterTheDeadline_DocumentTest extends PHPUnit_Framework_TestCase
{
  protected $Document;

  public function setUp() {
    $this->Document = AfterTheDeadline::factory('Document');

    // Sleep because the server is throttling and will return bad results if
    // we test too quickly.
    sleep(1);
  }

  /**
   * @group afterthedark
   * @group document
   */
  public function testDocumentGrammar() {
    $testFile = 'Tests/texts/grammar';
    $text = file_get_contents($testFile);

    $document = $this->Document->get($text);
    $this->assertSame('your an', (string)$document->error[0]->string);
    $this->assertSame("you're an", (string)$document->error[0]->suggestions->option);
    $this->assertSame('grammar', (string)$document->error[0]->type);
  }

  /**
   * @group afterthedark
   * @group document
   */
  public function testDocumentSpelling() {
    $testFile = 'Tests/texts/speller';
    $text = file_get_contents($testFile);

    $document = $this->Document->get($text);
    $this->assertSame('four', (string)$document->error[0]->string);
    $this->assertSame("for", (string)$document->error[0]->suggestions->option);
    $this->assertSame('spelling', (string)$document->error[0]->type);
  }

  /**
   * @group afterthedark
   * @group document
   */
  public function testDocumentStyle() {
    $testFile = 'Tests/texts/style';
    $text = file_get_contents($testFile);

    $document = $this->Document->get($text);
    $this->assertSame('utilized', (string)$document->error[0]->string);
    $this->assertSame("used", (string)$document->error[0]->suggestions->option);
    $this->assertSame('suggestion', (string)$document->error[0]->type);
  }
}
