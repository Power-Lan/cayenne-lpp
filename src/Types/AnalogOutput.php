<?php declare(strict_types=1);

namespace CayenneLPP\Types;

const LPP_ANALOG_OUTPUT = 3;
const LPP_ANALOG_OUTPUT_SIZE = 4;

trait AnalogOutput {
  public function addAnalogOutput(int $channel, float $value) : void
  {
    if ($value > 655.35) {
        throw new Exception('Value is too big to be encoded in AnalogOutput (max = 655.35)');
    }

    $value = round($value * 100);

    $this->addData($channel, LPP_ANALOG_OUTPUT, array(
      ($value >> 8) & 0xFF,
      $value & 0xFF
    ));
  }

  public function decodeAnalogOutput(string $bin) : array
  {
    if ($this->isLittleEndian()) {
      $bin = $this->swap16($bin);
    }

    $v = unpack('s', $bin)[1];
    return array(
      'value' => 0.01 * $v
    );
  }

  public function getAnalogOutputLPPType() : int
  {
    return LPP_ANALOG_OUTPUT;
  }

  public function getAnalogOutputLPPSize() : int
  {
    return LPP_ANALOG_OUTPUT_SIZE;
  }
}
