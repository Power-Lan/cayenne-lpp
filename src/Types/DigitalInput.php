<?php declare(strict_types=1);

namespace CayenneLPP\Types;

const LPP_DIGITAL_INPUT = 0;
const LPP_DIGITAL_INPUT_SIZE = 3;

trait DigitalInput {
  public function addDigitalInput(int $channel, bool $value) : void
  {
    $this->addData($channel, LPP_DIGITAL_INPUT, array(
      (int) $value
    ));
  }

  public function decodeDigitalInput(string $bin) : array
  {
    return array(
      'value' => bin2hex($bin) === '01'
    );
  }

  public function getDigitalInputLPPType() : int
  {
    return LPP_DIGITAL_INPUT;
  }

  public function getDigitalInputLPPSize() : int
  {
    return LPP_DIGITAL_INPUT_SIZE;
  }
}
