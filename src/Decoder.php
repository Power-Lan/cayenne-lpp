<?php declare(strict_types=1);

namespace CayenneLPP;

use Iterator;
use Countable;

const LPP_HEADER_SIZE = 2;

class Decoder implements Iterator, Countable
{
    use Endian,
      Types\DigitalInput,
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

    public $data;
    private $index;
    private $type2size;
    private $type2name;

    public function __construct(string $payload)
    {
        $this->type2size = array(
        Types\LPP_ACCELEROMETER         => Types\LPP_ACCELEROMETER_SIZE,
        Types\LPP_ANALOG_INPUT          => Types\LPP_ANALOG_INPUT_SIZE,
        Types\LPP_ANALOG_OUTPUT         => Types\LPP_ANALOG_OUTPUT_SIZE,
        Types\LPP_BAROMETRIC_PRESSURE   => Types\LPP_BAROMETRIC_PRESSURE_SIZE,
        Types\LPP_DIGITAL_INPUT         => Types\LPP_DIGITAL_INPUT_SIZE,
        Types\LPP_DIGITAL_OUTPUT        => Types\LPP_DIGITAL_OUTPUT_SIZE,
        Types\LPP_GPS                   => Types\LPP_GPS_SIZE,
        Types\LPP_GYROMETER             => Types\LPP_GYROMETER_SIZE,
        Types\LPP_LUMINOSITY            => Types\LPP_LUMINOSITY_SIZE,
        Types\LPP_PRESENCE              => Types\LPP_PRESENCE_SIZE,
        Types\LPP_RELATIVE_HUMIDITY     => Types\LPP_RELATIVE_HUMIDITY_SIZE,
        Types\LPP_TEMPERATURE           => Types\LPP_TEMPERATURE_SIZE,
        );

        $this->type2name = array(
        Types\LPP_ACCELEROMETER         => 'accelerometer',
        Types\LPP_ANALOG_INPUT          => 'analogInput',
        Types\LPP_ANALOG_OUTPUT         => 'analogOutput',
        Types\LPP_BAROMETRIC_PRESSURE   => 'pressure',
        Types\LPP_DIGITAL_INPUT         => 'digitalInput',
        Types\LPP_DIGITAL_OUTPUT        => 'digitalOutput',
        Types\LPP_GPS                   => 'gps',
        Types\LPP_GYROMETER             => 'gyrometer',
        Types\LPP_LUMINOSITY            => 'luminosity',
        Types\LPP_PRESENCE              => 'presence',
        Types\LPP_RELATIVE_HUMIDITY     => 'humidity',
        Types\LPP_TEMPERATURE           => 'temperature',
        );

        $this->data = $this->decode($payload);
        $this->index = 0;
    }

    private function decode(string $payload) : array
    {
        $out = array();
        $channel = 0;
        $type = 0;

      // Detect empty payload
        if ($payload === '') {
            return $out;
        }

        while (true) {
            if (strlen($payload) < LPP_HEADER_SIZE) {
                throw new Exception("Header is too short");
            }

          // Read frame (header + raw data)
            $channel = unpack('C', $payload[0])[1];
            $type = unpack('C', $payload[1])[1];
            $size = $this->getTypeSize($type) - LPP_HEADER_SIZE;
            $chunck = substr($payload, LPP_HEADER_SIZE, $size);
            if (strlen($chunck) !== $size) {
                throw new Exception('Incomplete data');
            }

          // Decode and store
            $out[] = array(
            'channel' => $channel,
            'type' => $type,
            'typeName' => $this->type2name[$type],
            'data' => $this->decodeType($type, $chunck)
            );

          // Reduce payload
            $payload = substr($payload, $size + LPP_HEADER_SIZE);
            if (strlen($payload) === 0) {
                break;
            }
        }

        return $out;
    }

    private function decodeType(int $type, string $data) : array
    {
        switch ($type) {
            case Types\LPP_ACCELEROMETER:
                return $this->decodeAccelerometer($data);

            case Types\LPP_ANALOG_INPUT:
                return $this->decodeAnalogInput($data);

            case Types\LPP_ANALOG_OUTPUT:
                return $this->decodeAnalogOutput($data);

            case Types\LPP_BAROMETRIC_PRESSURE:
                return $this->decodeBarometricPressure($data);

            case Types\LPP_DIGITAL_INPUT:
                return $this->decodeDigitalInput($data);

            case Types\LPP_DIGITAL_OUTPUT:
                return $this->decodeDigitalOutput($data);

            case Types\LPP_GPS:
                return $this->decodeGPS($data);

            case Types\LPP_GYROMETER:
                return $this->decodeGyrometer($data);

            case Types\LPP_LUMINOSITY:
                return $this->decodeLuminosity($data);

            case Types\LPP_PRESENCE:
                return $this->decodePresence($data);

            case Types\LPP_RELATIVE_HUMIDITY:
                return $this->decodeRelativeHumidity($data);

            case Types\LPP_TEMPERATURE:
                return $this->decodeTemperature($data);

            default:
                return array();
        }
    }

    private function getTypeSize(int $type) : int
    {
        if ($this->isTypeSupported($type) === false) {
            throw new Exception('Unknown type');
        }

        return $this->type2size[$type];
    }

    private function isTypeSupported(int $type) : bool
    {
        return array_key_exists($type, $this->type2size);
    }

    public function current()
    {
        return $this->data[$this->index];
    }

    public function key()
    {
        return $this->index;
    }

    public function next() : void
    {
        $this->index += 1;
    }

    public function rewind() : void
    {
        $this->index = 0;
    }

    public function valid() : bool
    {
        return isset($this->data[$this->index]);
    }

    public function count() : int
    {
        return count($this->data);
    }
}
