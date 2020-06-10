<?php declare(strict_types=1);

namespace CayenneLPP\Types;

const LPP_ANALOG_INPUT = 2;
const LPP_ANALOG_INPUT_SIZE = 4;

trait AnalogInput
{
    public function addAnalogInput(int $channel, float $value)
    {
        if ($value > 655.35) {
            throw new Exception('Value is too big to be encoded in AnalogInput (max = 655.35)');
        }

        $value = round($value * 100);

        $this->addData($channel, LPP_ANALOG_INPUT, array(
        ($value >> 8) & 0xFF,
        $value & 0xFF
        ));
    }

    public function decodeAnalogInput(string $bin) : array
    {
        if ($this->isLittleEndian()) {
            $bin = $this->swap16($bin);
        }

        $v = unpack('s', $bin)[1];
        return array(
        'value' => 0.01 * $v
        );
    }

    public function getAnalogInputLPPType() : int
    {
        return LPP_ANALOG_INPUT;
    }

    public function getAnalogInputLPPSize() : int
    {
        return LPP_ANALOG_INPUT_SIZE;
    }
}
