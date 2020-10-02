<?php

declare(strict_types=1);

namespace App\Response\Room;

use App\Response\Normalizer\DateTimeNormalizer;
use App\Response\Room\Normalizer\MessageCollectionNormalizer;
use App\Response\Room\Normalizer\MessageNormalizer;
use App\Response\Room\Normalizer\UserNormalizer;
use App\Response\Serializer\JsonSerializer;
use App\Room\Collection\MessageCollection;
use Symfony\Component\HttpFoundation\Response;

class MessagesJsonResponse extends Response
{
    public function __construct(MessageCollection $collection)
    {
        $normalizers = [
            new DateTimeNormalizer(),
            new MessageCollectionNormalizer(),

            new MessageNormalizer(),
            new UserNormalizer(),
        ];

        $content = (new JsonSerializer($normalizers))->serialize($collection);

        parent::__construct($content, Response::HTTP_OK);
    }
}