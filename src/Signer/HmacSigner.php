<?php
declare(strict_types=1);

namespace LessToken\Signer;

use LessToken\Signer\Key\Key;

final class HmacSigner extends AbstractSigner
{
    public function __construct(
        private readonly Key $key,
        string $algorithm,
    ) {
        parent::__construct($algorithm);
    }

    public function sign(string $data): string
    {
        return hash_hmac($this->getAlgorithm(), $data, (string)$this->key, true);
    }

    public function verify(string $data, string $signature): bool
    {
        return hash_equals($this->sign($data), $signature);
    }

    public function getEncryptionName(): string
    {
        return 'hmac';
    }
}
