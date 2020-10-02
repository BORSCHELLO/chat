<?php

declare(strict_types=1);

namespace App\Response\Normalizer;

use DateTimeInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class DateTimeNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    /**
     * @param DateTimeInterface $object
     * @param string|null $format
     * @param array $context
     * @return string
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        return $object->format('Y-m-d H:i:s');
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof DateTimeInterface;
    }
}