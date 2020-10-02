<?php

declare(strict_types=1);

namespace App\Response\Room\Normalizer;

use App\Room\Entity\Message;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class MessageNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    /**
     * @param Message $object
     * @param string|null $format
     * @param array $context
     * @return array|\ArrayObject|bool|float|int|string|void|null
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        $result = [
            'id' => $object->getId(),
            'message' => $object->getMessage(),
            'createdAt' => $this->normalizer->normalize($object->getCreatedAt(), $format, $context),
            'user' => $this->normalizer->normalize($object->getUser(), $format, $context),
        ];

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof Message;
    }
}