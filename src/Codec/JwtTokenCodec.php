<?php
declare(strict_types=1);

namespace LessToken\Codec;

use JsonException;
use LessToken\Codec\Exception\InvalidFormat;
use LessToken\Codec\Exception\InvalidSignature;
use LessToken\Signer\Signer;
use LessValueObject\Number\Int\Date\Timestamp;
use RuntimeException;
use Throwable;

final class JwtTokenCodec implements TokenCodec
{
    public function __construct(private readonly Signer $signer)
    {}

    public function encode(mixed $data, Timestamp $expire): string
    {
        if (!is_array($data)) {
            throw new RuntimeException('JWT only supports array');
        }

        $header = [
            'alg' => $this->getAlgorithName(),
            'typ' => 'JWT',
        ];

        $data['nbf'] = time();
        $data['iat'] = time();
        $data['exp'] = $expire->getValue();

        $partial = $this->urlEncode($this->jsonEncode($header))
            . '.' . $this->urlEncode($this->jsonEncode($data));

        return $partial
            . '.' . $this->urlEncode($this->signer->sign($partial));
    }

    /**
     * @throws InvalidFormat
     * @throws InvalidSignature
     */
    public function decode(string $token): mixed
    {
        if (preg_match('#^([a-zA-Z\d_-]+)\.([a-zA-Z\d_-]+)\.([a-zA-Z\d_-]+)$#', $token, $matches) !== 1) {
            throw new InvalidFormat();
        }

        try {
            $header = $this->jsonDecode($this->urlDecode($matches[1]));
        } catch (Throwable $e) {
            throw new InvalidFormat('Failed header', previous: $e);
        }

        if (!is_array($header)) {
            throw new InvalidFormat('Failed header, exepect array got ' . get_debug_type($header));
        }

        if (!isset($header['typ']) || $header['typ'] !== 'JWT') {
            throw new InvalidFormat('Failed header.typ');
        }

        if (!isset($header['alg']) || !is_string($header['alg']) || $header['alg'] !== $this->getAlgorithName()) {
            throw new InvalidFormat('Failed header.alg');
        }

        try {
            $claims = $this->jsonDecode($this->urlDecode($matches[2]));
        } catch (Throwable $e) {
            throw new InvalidFormat('Failed claims', previous: $e);
        }

        if (!is_array($claims)) {
            throw new InvalidFormat('Failed claims, exepect array got ' . get_debug_type($claims));
        }

        if (isset($claims['nbf'])) {
            if (!is_int($claims['nbf'])) {
                throw new InvalidFormat('Failed claims.nbf');
            }

            if ($claims['nbf'] > time()) {
                throw new RuntimeException();
            }
        }

        if (isset($claims['exp'])) {
            if (!is_int($claims['exp'])) {
                throw new InvalidFormat('Failed claims.exp');
            }

            if ($claims['exp'] < time()) {
                throw new RuntimeException();
            }
        }

        try {
            $signature = $this->urlDecode($matches[3]);
        } catch (Throwable $e) {
            throw new InvalidFormat('Failed signature', previous: $e);
        }

        if (!$this->signer->verify("{$matches[1]}.{$matches[2]}", $signature)) {
            throw new InvalidSignature();
        }

        return $claims;
    }

    /**
     * @throws JsonException
     */
    private function jsonEncode(mixed $input): string
    {
        return json_encode($input, flags: JSON_THROW_ON_ERROR);
    }

    /**
     * @throws JsonException
     */
    private function jsonDecode(string $input): mixed
    {
        return json_decode($input, true, flags: JSON_THROW_ON_ERROR);
    }

    private function urlEncode(string $input): string
    {
        return str_replace(
            ['+', '/', '='],
            ['-', '_', ''],
            base64_encode($input),
        );
    }

    private function urlDecode(string $input): string
    {
        $modulo = strlen($input) % 4;
        $input .= $modulo > 0
            ? str_repeat('=', 4 - $modulo)
            : '';

        $input = str_replace(
            ['-', '_'],
            ['+', '/'],
            $input,
        );

        $decoded = base64_decode($input, true);

        if (!is_string($decoded)) {
            throw new RuntimeException();
        }

        return $decoded;
    }

    private function getAlgorithName(): string
    {
        $algorithm = match ($this->signer->getEncryptionName()) {
            'hmac' => 'H',
            'rsa' => 'R',
            default => throw new RuntimeException(),
        };

        $algorithm .= match ($this->signer->getAlgorithm()) {
            'sha256' => 'S256',
            'sha384' => 'S384',
            'sha512' => 'S512',
            default => throw new RuntimeException(),
        };

        return $algorithm;
    }
}
