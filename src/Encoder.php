<?php declare(strict_types=1);

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

    /**
     * Internal function to add data into the encoder
     * @param int   $channel Channel number of the data
     * @param int   $type    Type of the data
     * @param array $payload Array of bytes to add into the encoder
     */
    protected function addData(int $channel, int $type, array $payload) : void
    {
        $this->buffer[] = $channel;
        $this->buffer[] = $type;
        $this->buffer = array_merge($this->buffer, $payload);
    }

    /**
     * Return the current size of the LPP payload
     * @return int Size in bytes
     */
    public function getSize() : int
    {
        return count($this->buffer);
    }

    /**
     * Return the current LPP payload
     * @return int payload in binary
     */
    public function getBuffer() : string
    {
        return pack('C*', ...$this->buffer);
    }

    /**
     * Clear all data
     */
    public function reset() : void
    {
        $this->buffer = array();
    }
}
