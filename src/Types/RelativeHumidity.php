<?php

namespace CayenneLPP\Types;

const LPP_RELATIVE_HUMIDITY = 104;
const LPP_RELATIVE_HUMIDITY_SIZE = 3;

trait RelativeHumidity {
  public function addRelativeHumidity(int $channel, float $value) : void
  {
    if ($value > 127.5) {
        throw new Exception('Value is too big to be encoded in RelativeHumidity (max = 127.5)');
    }

    $value = round($value * 2);

    $this->addData($channel, LPP_RELATIVE_HUMIDITY, array(
      (int) $value
    ));
  }

  public function decodeRelativeHumidity(string $bin) : array
  {
    $hr = unpack('C', $bin)[1];
    return array(
      'value' => 0.5 * $hr
    );
  }

  public function getRelativeHumidityLPPType() : int
  {
    return LPP_RELATIVE_HUMIDITY;
  }

  public function getRelativeHumidityLPPSize() : int
  {
    return LPP_RELATIVE_HUMIDITY_SIZE;
  }
}
