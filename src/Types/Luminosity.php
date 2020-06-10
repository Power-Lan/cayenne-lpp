<?php declare(strict_types=1);

namespace CayenneLPP\Types;

const LPP_LUMINOSITY = 101;
const LPP_LUMINOSITY_SIZE = 4;

trait Luminosity
{
    public function addLuminosity(int $channel, int $value)
    {
        if ($value > 65535) {
            throw new Exception('Value is too big to be encoded in Luminosity (max = 65535)');
        }

        $this->addData($channel, LPP_LUMINOSITY, array(
        ($value >> 8) & 0xFF,
        $value & 0xFF
        ));
    }

    public function decodeLuminosity(string $bin) : array
    {
        if ($this->isLittleEndian()) {
            $bin = $this->swap16($bin);
        }

        $l = unpack('s', $bin)[1];
        return array(
        'value' => $l
        );
    }

    public function getLuminosityLPPType() : int
    {
        return LPP_LUMINOSITY;
    }

    public function getLuminosityLPPSize() : int
    {
        return LPP_LUMINOSITY_SIZE;
    }
}
