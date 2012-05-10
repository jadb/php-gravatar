<?php
require dirname(dirname(__FILE__)) . '/Gravatar.php';
/**
 * Gravatar Tests.
 *
 * @package Tests
 * @author Jad Bitar
 */
class GravatarTest extends PHPUnit_Framework_TestCase {
  public function setUp() {
    $this->Gravatar = new Gravatar;
  }
  public function tearDown() {
    unset($this->Gravatar);
  }
  public function testUrl() {
    $expected = 'http://www.gravatar.com/avatar/e4803e3546fac36929ff1a15ece04efb?r=pg&s=80&d=mm';
    $result = $this->Gravatar->setEmail('jad@wdtmedia.com')->url();
    $this->assertEquals($expected, $result);

    $expected = 'https://secure.gravatar.com/avatar/e4803e3546fac36929ff1a15ece04efb?r=pg&s=80&d=mm';
    $result = $this->Gravatar->setEmail('jad@wdtmedia.com')->setSsl(true)->url();
    $this->assertEquals($expected, $result);

    $expected = 'http://www.gravatar.com/avatar/e4803e3546fac36929ff1a15ece04efb?r=g&s=300&d=404';
    $result = $this->Gravatar->setEmail('jad@wdtmedia.com')->setDefault('404')->setRating('g')->setSize(300)->setSsl(false)->url();
    $this->assertEquals($expected, $result);
  }
  public function testSetDefault() {
    $this->assertTrue(is_object($this->Gravatar->setDefault('http://domain.com/avatar.jpg')));
    $this->assertFalse($this->Gravatar->setDefault('invalid'));
  }
}
