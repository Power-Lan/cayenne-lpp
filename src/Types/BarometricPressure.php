<?php declare(strict_types=1);

namespace CayenneLPP\Types;

const LPP_BAROMETRIC_PRESSURE = 115;
const LPP_BAROMETRIC_PRESSURE_SIZE = 4;

trait BarometricPressure
{
    public function addBarometricPressure(int $channel, float $value)
    {
        if ($value > 6553.5) {
            throw new Exception('Value is too big to be encoded in BarometricPressure (max = 6553.5)');
        }

        $value = round($value * 10);

        $this->addData($channel, LPP_BAROMETRIC_PRESSURE, array(
        ($value >> 8) & 0xFF,
        $value & 0xFF
        ));
    }

    public function decodeBarometricPressure(string $bin) : array
    {
        if ($this->isLittleEndian()) {
            $bin = $this->swap16($bin);
        }

        $p = unpack('s', $bin)[1];
        return array(
        'value' => 0.1 * $p
        );
    }

    public function getBarometricPressureLPPType() : int
    {
        return LPP_BAROMETRIC_PRESSURE;
    }

    public function getBarometricPressureLPPSize() : int
    {
        return LPP_BAROMETRIC_PRESSURE_SIZE;
    }
}
