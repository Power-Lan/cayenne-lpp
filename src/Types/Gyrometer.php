<?php declare(strict_types=1);

namespace CayenneLPP\Types;

const LPP_GYROMETER = 134;
const LPP_GYROMETER_SIZE = 8;

trait Gyrometer
{
    public function addGyrometer(int $channel, float $x, float $y, float $z) : void
    {
        if ($x > 655.35) {
            throw new Exception('X Axis is too big to be encoded in Gyrometer (max = 655.35)');
        }
        if ($y > 655.35) {
            throw new Exception('Y Axis is too big to be encoded in Gyrometer (max = 655.35)');
        }
        if ($z > 655.35) {
            throw new Exception('Z Axis is too big to be encoded in Gyrometer (max = 655.35)');
        }

        $x = round($x * 100);
        $y = round($y * 100);
        $z = round($z * 100);

        $this->addData($channel, LPP_GYROMETER, array(
        ($x >> 8) & 0xFF,
        $x & 0xFF,
        ($y >> 8) & 0xFF,
        $y & 0xFF,
        ($z >> 8) & 0xFF,
        $z & 0xFF
        ));
    }

    public function decodeGyrometer(string $bin) : array
    {
        $bins = str_split($bin, 2);
        if ($this->isLittleEndian()) {
            array_walk($bins, function (&$item) {
                $item = $this->swap16($item);
            });
        }

        array_walk($bins, function (&$item) {
            $item = 0.01 * unpack('s', $item)[1];
        });
        return array(
        'x' => $bins[0],
        'y' => $bins[1],
        'z' => $bins[2]
        );
    }

    public function getGyrometerLPPType() : int
    {
        return LPP_GYROMETER;
    }

    public function getGyrometerLPPSize() : int
    {
        return LPP_GYROMETER_SIZE;
    }
}
