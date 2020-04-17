<?php

use CayenneLPP\Encoder;
use CayenneLPP\Decoder;
use PHPUnit\Framework\TestCase;

class ExceptionTest extends TestCase
{
    public function testAnalogInputTooLarge()
    {
      $lpp = new Encoder;
      $lpp->addAnalogInput(0, 3.14);

      $this->expectException(\CayenneLPP\Types\Exception::class);
      $lpp->addAnalogInput(1, 1024.2048);
    }

    public function testAnalogOutputTooLarge()
    {
      $lpp = new Encoder;
      $lpp->addAnalogOutput(0, 1.12);

      $this->expectException(\CayenneLPP\Types\Exception::class);
      $lpp->addAnalogOutput(1, 1024.2048);
    }

    public function testLuminosityTooLarge()
    {
      $lpp = new Encoder;
      $lpp->addLuminosity(0, 250);

      $this->expectException(\CayenneLPP\Types\Exception::class);
      $lpp->addLuminosity(1, 70000);
    }

    public function testTemperatureTooLarge()
    {
      $lpp = new Encoder;
      $lpp->addTemperature(0, 20.0);

      $this->expectException(\CayenneLPP\Types\Exception::class);
      $lpp->addTemperature(1, 7000.0);
    }

    public function testRelativeHumidityTooLarge()
    {
      $lpp = new Encoder;
      $lpp->addRelativeHumidity(0, 50.0);

      $this->expectException(\CayenneLPP\Types\Exception::class);
      $lpp->addRelativeHumidity(1, 2048.0);
    }

    public function testAccelerometerXTooLarge()
    {
      $lpp = new Encoder;
      $lpp->addAccelerometer(0, 1.0, 0.0, 0.0);

      $this->expectException(\CayenneLPP\Types\Exception::class);
      $lpp->addAccelerometer(1, 2048.0, 0.0, 0.0);
    }

    public function testAccelerometerYTooLarge()
    {
      $lpp = new Encoder;
      $lpp->addAccelerometer(0, 0.0, 1.0, 0.0);

      $this->expectException(\CayenneLPP\Types\Exception::class);
      $lpp->addAccelerometer(1, 0.0, 2048.0, 0.0);
    }

    public function testAccelerometerZTooLarge()
    {
      $lpp = new Encoder;
      $lpp->addAccelerometer(0, 0.0, 0.0, 1.0);

      $this->expectException(\CayenneLPP\Types\Exception::class);
      $lpp->addAccelerometer(1, 0.0, 0.0, 2048.0);
    }

    public function testBarometricPressureTooLarge()
    {
      $lpp = new Encoder;
      $lpp->addBarometricPressure(0, 1000.0);

      $this->expectException(\CayenneLPP\Types\Exception::class);
      $lpp->addBarometricPressure(1, 10000.0);
    }

    public function testGyrometerXTooLarge()
    {
      $lpp = new Encoder;
      $lpp->addGyrometer(0, 600.0, 0.0, 0.0);

      $this->expectException(\CayenneLPP\Types\Exception::class);
      $lpp->addGyrometer(1, 2048.0, 0.0, 0.0);
    }

    public function testGyrometerYTooLarge()
    {
      $lpp = new Encoder;
      $lpp->addGyrometer(0, 0.0, 600.0, 0.0);

      $this->expectException(\CayenneLPP\Types\Exception::class);
      $lpp->addGyrometer(1, 0.0, 2048.0, 0.0);
    }

    public function testGyrometerZTooLarge()
    {
      $lpp = new Encoder;
      $lpp->addGyrometer(0, 0.0, 0.0, 600.0);

      $this->expectException(\CayenneLPP\Types\Exception::class);
      $lpp->addGyrometer(1, 0.0, 0.0, 2048.0);
    }

    public function testGPSLatTooLarge()
    {
      $lpp = new Encoder;
      $lpp->addGPS(0, 0.0, 0.0, 0.0);

      $this->expectException(\CayenneLPP\Types\Exception::class);
      $lpp->addGPS(1, 2000.0, 0.0, 0.0);
    }

    public function testGPSLonTooLarge()
    {
      $lpp = new Encoder;
      $lpp->addGPS(0, 0.0, 0.0, 0.0);

      $this->expectException(\CayenneLPP\Types\Exception::class);
      $lpp->addGPS(1, 0.0, 2000.0, 0.0);
    }

    public function testGPSAltTooLarge()
    {
      $lpp = new Encoder;
      $lpp->addGPS(0, 0.0, 0.0, 1.0);

      $this->expectException(\CayenneLPP\Types\Exception::class);
      $lpp->addGPS(1, 0.0, 0.0, 200000.0);
    }

    public function testDecodeHeaderTooShort()
    {
      $this->expectException(\CayenneLPP\Exception::class);
      $lpp = new Decoder('00');
    }

    public function testDecodeDataTooShort()
    {
      $this->expectException(\CayenneLPP\Exception::class);
      $lpp = new Decoder('018806');
    }
}
