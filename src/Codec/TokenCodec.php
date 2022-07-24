<?php
declare(strict_types=1);

namespace LessToken\Codec;

use LessValueObject\Number\Int\Date\Timestamp;

interface TokenCodec
{
    public function encode(mixed $data, Timestamp $expire): string;

    public function decode(string $token): mixed;
}
