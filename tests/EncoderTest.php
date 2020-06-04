<?php declare(strict_types=1);

namespace CayenneLPP\Test;

use CayenneLPP\Encoder;
use PHPUnit\Framework\TestCase;

class EncoderTest extends TestCase
{
    public function testDigitalInput()
    {
        $lpp = new Encoder;
        $lpp->addDigitalInput(0, true);
        $lpp->addDigitalInput(1, false);
        $lpp->addDigitalInput(2, false);
        $lpp->addDigitalInput(3, true);
        $buffer = $lpp->getBuffer();
        $size = $lpp->getSize();

        $this->assertEquals($size, $lpp->getDigitalInputLPPSize() * 4);
        $this->assertEquals($buffer, hex2bin('000001' . '010000' . '020000' . '030001'));
    }

    public function testDigitalOutput()
    {
        $lpp = new Encoder;
        $lpp->addDigitalOutput(0, true);
        $lpp->addDigitalOutput(1, false);
        $lpp->addDigitalOutput(2, false);
        $lpp->addDigitalOutput(3, true);
        $buffer = $lpp->getBuffer();
        $size = $lpp->getSize();

        $this->assertEquals($size, $lpp->getDigitalOutputLPPSize() * 4);
        $this->assertEquals($buffer, hex2bin('000101' . '010100' . '020100' . '030101'));
    }

    public function testAnalogInput()
    {
        $lpp = new Encoder;
        $lpp->addAnalogInput(0, 22.25);
        $lpp->addAnalogInput(1, 1.25);
        $lpp->addAnalogInput(2, -0.35);
        $lpp->addAnalogInput(3, -19.21);
        $buffer = $lpp->getBuffer();
        $size = $lpp->getSize();

        $this->assertEquals($size, $lpp->getAnalogInputLPPSize() * 4);
        $this->assertEquals($buffer, hex2bin('000208B1' . '0102007D' . '0202FFDD' . '0302F87F'));
    }

    public function testAnalogOutput()
    {
        $lpp = new Encoder;
        $lpp->addAnalogOutput(0, 22.25);
        $lpp->addAnalogOutput(1, 1.25);
        $lpp->addAnalogOutput(2, -0.35);
        $lpp->addAnalogOutput(3, -19.21);
        $buffer = $lpp->getBuffer();
        $size = $lpp->getSize();

        $this->assertEquals($size, $lpp->getAnalogOutputLPPSize() * 4);
        $this->assertEquals($buffer, hex2bin('000308B1' . '0103007D' . '0203FFDD' . '0303F87F'));
    }

    public function testLuminosity()
    {
        $lpp = new Encoder;
        $lpp->addLuminosity(0, 250);
        $lpp->addLuminosity(1, 700);
        $buffer = $lpp->getBuffer();
        $size = $lpp->getSize();

        $this->assertEquals($size, $lpp->getLuminosityLPPSize() * 2);
        $this->assertEquals($buffer, hex2bin('006500FA' . '016502BC'));
    }

    public function testPresence()
    {
        $lpp = new Encoder;
        $lpp->addPresence(0, true);
        $lpp->addPresence(1, false);
        $lpp->addPresence(2, false);
        $lpp->addPresence(3, true);
        $buffer = $lpp->getBuffer();
        $size = $lpp->getSize();

        $this->assertEquals($size, $lpp->getPresenceLPPSize() * 4);
        $this->assertEquals($buffer, hex2bin('006601' . '016600' . '026600' . '036601'));
    }

    public function testTemperature()
    {
        $lpp = new Encoder;
        $lpp->addTemperature(0, 20.0);
        $lpp->addTemperature(1, -30.0);
        $lpp->addTemperature(2, 20.0);
        $buffer = $lpp->getBuffer();
        $size = $lpp->getSize();

        $this->assertEquals($size, $lpp->getTemperatureLPPSize() * 3);
        $this->assertEquals($buffer, hex2bin('006700c8' . '0167fed4' . '026700c8'));
    }

    public function testRelativeHumidity()
    {
        $lpp = new Encoder;
        $lpp->addRelativeHumidity(0, 54.5);
        $buffer = $lpp->getBuffer();
        $size = $lpp->getSize();

        $this->assertEquals($size, $lpp->getRelativeHumidityLPPSize() * 1);
        $this->assertEquals($buffer, hex2bin('00686D'));
    }

    public function testAccelerometer()
    {
        $lpp = new Encoder;
        $lpp->addAccelerometer(0, -0.120, -0.360, 9.812);
        $lpp->addAccelerometer(1, 9.812, -0.120, -0.360);
        $buffer = $lpp->getBuffer();
        $size = $lpp->getSize();

        $this->assertEquals($size, $lpp->getAccelerometerLPPSize() * 2);
        $this->assertEquals($buffer, hex2bin('0071ff88fe982654' . '01712654ff88fe98'));
    }

    public function testBarometricPressure()
    {
        $lpp = new Encoder;
        $lpp->addBarometricPressure(0, 978.1);
        $lpp->addBarometricPressure(1, 1050.3);
        $buffer = $lpp->getBuffer();
        $size = $lpp->getSize();

        $this->assertEquals($size, $lpp->getBarometricPressureLPPSize() * 2);
        $this->assertEquals($buffer, hex2bin('00732635' . '01732907'));
    }

    public function testGyrometer()
    {
        $lpp = new Encoder;
        $lpp->addGyrometer(0, 1.12, 3.14, -0.01);
        $lpp->addGyrometer(1, -0.01, 1.12, 3.14);
        $buffer = $lpp->getBuffer();
        $size = $lpp->getSize();

        $this->assertEquals($size, $lpp->getGyrometerLPPSize() * 2);
        $this->assertEquals($buffer, hex2bin('00860070013AFFFF' . '0186FFFF0070013A'));
    }

    public function testGPS()
    {
        $lpp = new Encoder;
        $lpp->addGPS(0, 0.0, 0.0, 0.0);
        $lpp->addGPS(1, 42.3519, -87.9094, 10);
        $buffer = $lpp->getBuffer();
        $size = $lpp->getSize();

        $this->assertEquals($size, $lpp->getGPSLPPSize() * 2);
        $this->assertEquals($buffer, hex2bin('0088000000000000000000' . '018806765ff2960a0003e8'));
    }
}
