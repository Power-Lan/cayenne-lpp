<?php declare(strict_types=1);

namespace CayenneLPP\Types;

const LPP_PRESENCE = 102;
const LPP_PRESENCE_SIZE = 3;

trait Presence
{
    public function addPresence(int $channel, bool $value)
    {
        $this->addData($channel, LPP_PRESENCE, array(
        (int) $value
        ));
    }

    public function decodePresence(string $bin) : array
    {
        return array(
        'value' => bin2hex($bin) === '01'
        );
    }

    public function getPresenceLPPType() : int
    {
        return LPP_PRESENCE;
    }

    public function getPresenceLPPSize() : int
    {
        return LPP_PRESENCE_SIZE;
    }
}
