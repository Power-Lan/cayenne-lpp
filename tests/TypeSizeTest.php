<?php declare(strict_types=1);

use CayenneLPP\Encoder;
use PHPUnit\Framework\TestCase;

class TypeSizeTest extends TestCase
{
    public function testDigitalInput()
    {
      $lpp = new Encoder;
      $this->assertEquals(0, $lpp->getDigitalInputLPPType());
      $this->assertEquals(3, $lpp->getDigitalInputLPPSize());
    }

    public function testDigitalOutput()
    {
      $lpp = new Encoder;
      $this->assertEquals(1, $lpp->getDigitalOutputLPPType());
      $this->assertEquals(3, $lpp->getDigitalOutputLPPSize());
    }

    public function testAnalogInput()
    {
      $lpp = new Encoder;
      $this->assertEquals(2, $lpp->getAnalogInputLPPType());
      $this->assertEquals(4, $lpp->getAnalogInputLPPSize());
    }

    public function testAnalogOutput()
    {
      $lpp = new Encoder;
      $this->assertEquals(3, $lpp->getAnalogOutputLPPType());
      $this->assertEquals(4, $lpp->getAnalogOutputLPPSize());
    }

    public function testLuminosity()
    {
      $lpp = new Encoder;
      $this->assertEquals(101, $lpp->getLuminosityLPPType());
      $this->assertEquals(4, $lpp->getLuminosityLPPSize());
    }

    public function testPresence()
    {
      $lpp = new Encoder;
      $this->assertEquals(102, $lpp->getPresenceLPPType());
      $this->assertEquals(3, $lpp->getPresenceLPPSize());
    }

    public function testTemperature()
    {
      $lpp = new Encoder;
      $this->assertEquals(103, $lpp->getTemperatureLPPType());
      $this->assertEquals(4, $lpp->getTemperatureLPPSize());
    }

    public function testRelativeHumidity()
    {
      $lpp = new Encoder;
      $this->assertEquals(104, $lpp->getRelativeHumidityLPPType());
      $this->assertEquals(3, $lpp->getRelativeHumidityLPPSize());
    }

    public function testAccelerometer()
    {
      $lpp = new Encoder;
      $this->assertEquals(113, $lpp->getAccelerometerLPPType());
      $this->assertEquals(8, $lpp->getAccelerometerLPPSize());
    }

    public function testBarometricPressure()
    {
      $lpp = new Encoder;
      $this->assertEquals(115, $lpp->getBarometricPressureLPPType());
      $this->assertEquals(4, $lpp->getBarometricPressureLPPSize());
    }

    public function testGyrometer()
    {
      $lpp = new Encoder;
      $this->assertEquals(134, $lpp->getGyrometerLPPType());
      $this->assertEquals(8, $lpp->getGyrometerLPPSize());
    }

    public function testGPS()
    {
      $lpp = new Encoder;
      $this->assertEquals(136, $lpp->getGPSLPPType());
      $this->assertEquals(11, $lpp->getGPSLPPSize());
    }
}
