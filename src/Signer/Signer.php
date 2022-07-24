<?php
declare(strict_types=1);

namespace LessToken\Signer;

interface Signer
{
    public function sign(string $data): string;

    public function verify(string $data, string $signature): bool;

    public function getEncryptionName(): string;

    public function getAlgorithm(): string;
}
