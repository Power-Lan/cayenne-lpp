PHP Cayenne LPP encoder and decoder
===================================

[![Build Status](https://travis-ci.org/Power-Lan/cayenne-lpp.svg?branch=master)](https://travis-ci.org/Power-Lan/cayenne-lpp)

This library can encode and decode data stream for LoraWan and SigFox devices which use Cayenne LPP encoding.


Encoder exemple
---------------

    $encoder = new CayenneLPP\Encoder;
    $encoder->addTemperature(0, 20.0);
    $encoder->addTemperature(1, 21.0);
    $buffer = $encoder->getBuffer();
    $size = $encoder->getSize();


Decoder exemple
---------------

The decoder implements the `Countable` interface.
It's allow to known how many dataset are in the binary stream.

    $decoded = new CayenneLPP\Decoder(hex2bin('00860070013AFFFF' . '0186FFFF0070013A'));
    $nbChannels = count($decoded);


The decoder implements `Iterator` interface.
Each item are array which contains the data channel index, the data type, and the data decoded.

    $decoded = new CayenneLPP\Decoder(hex2bin('00860070013AFFFF' . '0186FFFF0070013A'));
    $nbChannels = count($decoded);
    foreach ($decoded as $data) {
      $channel = $data['channel'];
      $type = $data['type'];
      $data = $data['data'];
    }
