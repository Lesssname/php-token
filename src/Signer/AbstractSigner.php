<?php
declare(strict_types=1);

namespace LessToken\Signer;

abstract class AbstractSigner implements Signer
{
    public function __construct(protected readonly string $algorithm)
    {}

    public function getAlgorithm(): string
    {
        return $this->algorithm;
    }
}
