<?php

declare(strict_types=1);

namespace App\Response\Room\Normalizer;

use App\Room\Collection\MessageCollection;
use App\Room\Entity\Message;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class MessageCollectionNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    /**
     * @inheritDoc
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        $result = [];

        /** @var Message $message */
        foreach ($object as $message) {
            $result[] = $this->normalizer->normalize($message, $format, $context);
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof MessageCollection;
    }
}