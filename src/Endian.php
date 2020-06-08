<?php declare(strict_types=1);

namespace CayenneLPP;

trait Endian
{
    /**
     * Detect if the execution platform is little endian
     * @return bool isLittleEndian
     */
    public function isLittleEndian() : bool
    {
        return unpack('S', "\x01\x00")[1] === 1;
    }

    /**
     * Swap bytes of a 16 bits number
     * @param  string $in number
     * @return string     number in other endian
     */
    public function swap16(string $in) : string
    {
        return $in[1] . $in[0];
    }

    /**
     * Swap bytes of a 24 bits number
     * @param  string $in number
     * @return string     number in other endian
     */
    public function swap24(string $in) : string
    {
        return $in[2] . $in[1] . $in[0];
    }
}
