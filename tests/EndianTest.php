<?php declare(strict_types=1);

namespace CayenneLPP\Test;

use CayenneLPP\Encoder;
use CayenneLPP\Decoder;
use CayenneLPP\Test\EndianTest\DummyDecoder;
use PHPUnit\Framework\TestCase;

class EndianTest extends TestCase
{
    public function testDetectEndian()
    {
        $decoder = new DummyDecoder;

      // Here we assume that tests run only on little endian computer (i.e. x86 or amd64)
        $this->assertEquals($decoder->isLittleEndian(), true);
    }


    public function testSwap16()
    {
        $decoder = new DummyDecoder;

        $input = hex2bin("01ab");
        $reverse = hex2bin("ab01");
        $this->assertEquals($decoder->swap16($input), $reverse);
    }

    public function testSwap24()
    {
        $decoder = new DummyDecoder;

        $input = hex2bin("e401ab");
        $reverse = hex2bin("ab01e4");
        $this->assertEquals($decoder->swap24($input), $reverse);
    }
}
