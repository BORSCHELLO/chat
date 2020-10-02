<?php

declare(strict_types=1);

namespace App\Response\Serializer;

use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer as SymfonySerializer;

class JsonSerializer
{
    private array $normalizers;

    private array $encoders;

    public function __construct(array $normalizers = [], array $encoders = [])
    {
        $this->normalizers = $normalizers;
        $this->encoders = array_merge($encoders, [
            new JsonEncoder(
                new JsonEncode(
                    [
                        JsonEncode::OPTIONS => JSON_UNESCAPED_UNICODE
                    ]
                )
            ),
        ]);
    }

    public function serialize($data): string
    {
        return (new SymfonySerializer($this->normalizers, $this->encoders))->serialize($data, 'json');
    }
}