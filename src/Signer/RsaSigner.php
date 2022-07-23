<?php
declare(strict_types=1);

namespace LessToken\Signer;

use LessToken\Signer\Key\Key;

final class RsaSigner implements Signer
{
    public function __construct(
        private readonly Key $keyPrivate,
        private readonly Key $keyPublic,
        private readonly string $algorithm,
    ) {}

    public function create(string $data): string
    {
        openssl_sign(
            $data,
            $signature,
            (string)$this->keyPrivate,
            $this->algorithm,
        );

        return $signature;
    }

    public function verify(string $data, string $signature): bool
    {
        return openssl_verify(
            $data,
            $signature,
            (string)$this->keyPublic,
            $this->algorithm,
        ) === 1;
    }
}
