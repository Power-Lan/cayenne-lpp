<?php

namespace CayenneLPP\Types;

const LPP_ACCELEROMETER = 113;
const LPP_ACCELEROMETER_SIZE = 8;

trait Accelerometer {
  public function addAccelerometer(int $channel, float $x, float $y, float $z) : void
  {
    if ($x > 65.535) {
        throw new Exception('X Axis is too big to be encoded in Accelerometer (max = 65.535)');
    }
    if ($y > 65.535) {
        throw new Exception('Y Axis is too big to be encoded in Accelerometer (max = 65.535)');
    }
    if ($z > 65.535) {
        throw new Exception('Z Axis is too big to be encoded in Accelerometer (max = 65.535)');
    }

    $x = round($x * 1000);
    $y = round($y * 1000);
    $z = round($z * 1000);

    $this->addData($channel, LPP_ACCELEROMETER, array(
      ($x >> 8) & 0xFF,
      $x & 0xFF,
      ($y >> 8) & 0xFF,
      $y & 0xFF,
      ($z >> 8) & 0xFF,
      $z & 0xFF
    ));
  }

  public function decodeAccelerometer(string $bin) : array
  {
    $bins = str_split($bin, 2);
    if ($this->isLittleEndian()) {
      array_walk($bins, function(&$item) {
        $item = $this->swap16($item);
      });
    }

    array_walk($bins, function(&$item) {
      $item = 0.001 * unpack('s', $item)[1];
    });
    return array(
      'x' => $bins[0],
      'y' => $bins[1],
      'z' => $bins[2]
    );
  }

  public function getAccelerometerLPPType() : int
  {
    return LPP_ACCELEROMETER;
  }

  public function getAccelerometerLPPSize() : int
  {
    return LPP_ACCELEROMETER_SIZE;
  }
}
