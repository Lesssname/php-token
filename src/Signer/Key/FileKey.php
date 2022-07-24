<?php
declare(strict_types=1);

namespace LessToken\Signer\Key;

/**
 * @psalm-immutable
 */
final class FileKey implements Key
{
    public function __construct(private readonly string $file)
    {}

    /**
     * @psalm-suppress ImpureFunctionCall
     */
    public function __toString(): string
    {
        assert(file_exists($this->file));
        assert(is_readable($this->file));

        $contents = file_get_contents($this->file);
        assert(is_string($contents));

        return $contents;
    }
}
