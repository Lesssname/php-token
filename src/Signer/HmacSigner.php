<?php
declare(strict_types=1);

namespace LessToken\Signer;

use LessToken\Signer\Key\Key;

final class HmacSigner implements Signer
{
    public function __construct(
        private readonly Key $key,
        private readonly string $algorithm,
    ) {}

    public function create(string $data): string
    {
        return hash_hmac($this->algorithm, $data, (string)$this->key, true);
    }

    public function verify(string $data, string $signature): bool
    {
        return hash_equals($this->create($data), $signature);
    }
}
