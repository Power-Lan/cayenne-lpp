<?php declare(strict_types=1);

namespace CayenneLPP\Types;

const LPP_GPS = 136;
const LPP_GPS_SIZE = 11;

trait GPS
{
    public function addGPS(int $channel, float $latitude, float $longitude, float $altitude)
    {
        if ($latitude > 1677.7215) {
            throw new Exception('Latitude is too big to be encoded in GPS (max = 1677.7215)');
        }
        if ($longitude > 1677.7215) {
            throw new Exception('Longitude is too big to be encoded in GPS (max = 1677.7215)');
        }
        if ($altitude > 167772.15) {
            throw new Exception('Altitude is too big to be encoded in GPS (max = 167772.15)');
        }

        $latitude = round($latitude * 10000);
        $longitude = round($longitude * 10000);
        $altitude = round($altitude * 100);

        $this->addData($channel, LPP_GPS, array(
        ($latitude >> 16) & 0xFF,
        ($latitude >> 8) & 0xFF,
        $latitude & 0xFF,
        ($longitude >> 16) & 0xFF,
        ($longitude >> 8) & 0xFF,
        $longitude & 0xFF,
        ($altitude >> 16) & 0xFF,
        ($altitude >> 8) & 0xFF,
        $altitude & 0xFF
        ));
    }

    public function decodeGPS(string $bin) : array
    {
        $bins = str_split($bin, 3);

        if ($this->isLittleEndian()) {
            array_walk($bins, function (&$item) {
                $sign = unpack('C', $item[0])[1];

                if ($sign > 127) {
                    $item = $this->swap24($item) . "\xFF";
                } else {
                    $item = $this->swap24($item) . "\x00";
                }
            });
        } else {
            array_walk($bins, function (&$item) {
                $sign = unpack('C', $item[2])[1];

                if ($sign > 127) {
                    $item = "\xFF" . $item;
                } else {
                    $item = "\x00" . $item;
                }
            });
        }

        array_walk($bins, function (&$item) {
            $item = unpack('l', $item)[1];
        });

        return array(
        'latitude' => 0.0001 * $bins[0],
        'longitude' => 0.0001 * $bins[1],
        'altitude' => 0.01 * $bins[2]
        );
    }

    public function getGPSLPPType() : int
    {
        return LPP_GPS;
    }

    public function getGPSLPPSize() : int
    {
        return LPP_GPS_SIZE;
    }
}
