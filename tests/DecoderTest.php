<?php declare(strict_types=1);

namespace CayenneLPP\Test;

use CayenneLPP\Encoder;
use CayenneLPP\Decoder;

use PHPUnit\Framework\TestCase;

class DecoderTest extends TestCase
{
    public function testDigitalInput()
    {
        $values = array(true, false, false, true);
        $decoded = new Decoder(hex2bin('000001' . '010000' . '020000' . '030001'));

        $this->assertEquals(count($decoded), 4);
        foreach ($decoded as $index => $data) {
            $channel = $data['channel'];
            $this->assertEquals($values[$channel], $data['data']['value']);
        }
    }

    public function testDigitalOutput()
    {
        $values = array(true, false, false, true);
        $decoded = new Decoder(hex2bin('000101' . '010100' . '020100' . '030101'));

        $this->assertEquals(count($decoded), 4);
        foreach ($decoded as $index => $data) {
            $channel = $data['channel'];
            $this->assertEquals($values[$channel], $data['data']['value']);
        }
    }

    public function testAnalogInput()
    {
        $values = array(22.25, 1.25, -0.35, -19.21);
        $decoded = new Decoder(hex2bin('000208B1' . '0102007D' . '0202FFDD' . '0302F87F'));

        $this->assertEquals(count($decoded), 4);
        foreach ($decoded as $index => $data) {
            $channel = $data['channel'];
            $this->assertEquals($values[$channel], $data['data']['value']);
        }
    }

    public function testAnalogOutput()
    {
        $values = array(22.25, 1.25, -0.35, -19.21);
        $decoded = new Decoder(hex2bin('000308B1' . '0103007D' . '0203FFDD' . '0303F87F'));

        $this->assertEquals(count($decoded), 4);
        foreach ($decoded as $index => $data) {
            $channel = $data['channel'];
            $this->assertEquals($values[$channel], $data['data']['value']);
        }
    }

    public function testLuminosity()
    {
        $values = array(250, 700);
        $decoded = new Decoder(hex2bin('006500FA' . '016502BC'));

        $this->assertEquals(count($decoded), 2);
        foreach ($decoded as $index => $data) {
            $channel = $data['channel'];
            $this->assertEquals($values[$channel], $data['data']['value']);
        }
    }

    public function testPresence()
    {
        $values = array(true, false, false, true);
        $decoded = new Decoder(hex2bin('006601' . '016600' . '026600' . '036601'));

        $this->assertEquals(count($decoded), 4);
        foreach ($decoded as $index => $data) {
            $channel = $data['channel'];
            $this->assertEquals($values[$channel], $data['data']['value']);
        }
    }

    public function testTemperature()
    {
        $values = array(20.0, -30.0, 20.0);
        $decoded = new Decoder(hex2bin('006700c8' . '0167fed4' . '026700c8'));

        $this->assertEquals(count($decoded), 3);
        foreach ($decoded as $data) {
            $channel = $data['channel'];
            $this->assertEquals($values[$channel], $data['data']['value']);
        }
    }

    public function testRelativeHumidity()
    {
        $values = array(54.5);
        $decoded = new Decoder(hex2bin('00686D'));

        $this->assertEquals(count($decoded), 1);
        foreach ($decoded as $data) {
            $channel = $data['channel'];
            $this->assertEquals($values[$channel], $data['data']['value']);
        }
    }

    public function testAccelerometer()
    {
        $values = array(
        array('x' => -0.120, 'y' => -0.360, 'z' => 9.812),
        array('x' => 9.812, 'y' => -0.120, 'z' => -0.360)
        );
        $decoded = new Decoder(hex2bin('0071ff88fe982654' . '01712654ff88fe98'));

        $this->assertEquals(count($decoded), 2);
        foreach ($decoded as $data) {
            $channel = $data['channel'];
            $this->assertEquals($values[$channel], $data['data']);
        }
    }

    public function testBarometricPressure()
    {
        $values = array(978.1, 1050.3);
        $decoded = new Decoder(hex2bin('00732635' . '01732907'));

        $this->assertEquals(count($decoded), 2);
        foreach ($decoded as $index => $data) {
            $channel = $data['channel'];
            $this->assertEquals($values[$channel], $data['data']['value']);
        }
    }

    public function testGyrometer()
    {
        $values = array(
        array('x' => 1.12, 'y' => 3.14, 'z' => -0.01),
        array('x' => -0.01, 'y' => 1.12, 'z' => 3.14)
        );
        $decoded = new Decoder(hex2bin('00860070013AFFFF' . '0186FFFF0070013A'));

        $this->assertEquals(count($decoded), 2);
        foreach ($decoded as $data) {
            $channel = $data['channel'];
            $this->assertEquals($values[$channel], $data['data']);
        }
    }

    public function testGPS()
    {
        $values = array(
        array('latitude' => 0.0, 'longitude' => 0.0, 'altitude' => 0.0),
        array('latitude' => 42.3519, 'longitude' => -87.9094, 'altitude' => 10.0)
        );
        $decoded = new Decoder(hex2bin('0088000000000000000000' . '018806765ff2960a0003e8'));

        $this->assertEquals(count($decoded), 2);
        foreach ($decoded as $data) {
            $channel = $data['channel'];
            $this->assertEquals($values[$channel], $data['data']);
        }
    }
}
