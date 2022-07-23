<?php
declare(strict_types=1);

namespace LessToken\Signer\Key;

interface Key
{
    public function __toString(): string;
}
