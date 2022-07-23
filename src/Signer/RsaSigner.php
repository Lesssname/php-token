<?php
declare(strict_types=1);

namespace LessToken\Signer;

use LessToken\Signer\Key\Key;

final class RsaSigner extends AbstractSigner
{
    public function __construct(
        private readonly Key $keyPrivate,
        private readonly Key $keyPublic,
        string $algorithm,
    ) {
        parent::__construct($algorithm);
    }

    public function create(string $data): string
    {
        openssl_sign(
            $data,
            $signature,
            (string)$this->keyPrivate,
            $this->getAlgorithm(),
        );

        return $signature;
    }

    public function verify(string $data, string $signature): bool
    {
        return openssl_verify(
            $data,
            $signature,
            (string)$this->keyPublic,
                $this->getAlgorithm(),
        ) === 1;
    }

    public function getEncryptionName(): string
    {
        return 'rsa';
    }
}
