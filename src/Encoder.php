<?php

namespace CayenneLPP;

class Encoder
{
  use Types\DigitalInput,
      Types\DigitalOutput,
      Types\AnalogInput,
      Types\AnalogOutput,
      Types\Luminosity,
      Types\Presence,
      Types\Temperature,
      Types\RelativeHumidity,
      Types\Accelerometer,
      Types\BarometricPressure,
      Types\Gyrometer,
      Types\GPS;

  private $buffer;

  public function __construct()
  {
    $this->reset();
  }

  protected function addData(int $channel, int $type, array $payload) : void
  {
    $this->buffer[] = $channel;
    $this->buffer[] = $type;
    $this->buffer = array_merge($this->buffer, $payload);
  }

  public function getSize() : int
  {
    return count($this->buffer);
  }

  public function getBuffer() : string
  {
    return pack('C*', ...$this->buffer);
  }

  public function reset() : void
  {
    $this->buffer = array();
  }
}
