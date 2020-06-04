<?php declare(strict_types=1);

namespace CayenneLPP;

trait Endian
{
    public function isLittleEndian() : bool
    {
        return unpack('S', "\x01\x00")[1] === 1;
    }

    public function swap16(string $in) : string
    {
        return $in[1] . $in[0];
    }

    public function swap24(string $in) : string
    {
        return $in[2] . $in[1] . $in[0];
    }
}
