<?php

use CayenneLPP\Encoder;
use CayenneLPP\Decoder;

use PHPUnit\Framework\TestCase;

class Tool {
  use CayenneLPP\Endian;
}

class EndianTest extends TestCase
{
    public function testDetectEndian()
    {
      $tool = new Tool;

      // Here we assume that tests run only on little endian computer (i.e. x86 or amd64)
      $this->assertEquals($tool->isLittleEndian(), true);
    }


    public function testSwap16()
    {
      $tool = new Tool;

      $input = hex2bin("01ab");
      $reverse = hex2bin("ab01");
      $this->assertEquals($tool->swap16($input), $reverse);
    }

    public function testSwap24()
    {
      $tool = new Tool;

      $input = hex2bin("e401ab");
      $reverse = hex2bin("ab01e4");
      $this->assertEquals($tool->swap24($input), $reverse);
    }
}
