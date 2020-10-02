<?php

declare(strict_types=1);

namespace App\Room\Repository;

use App\Room\Collection\MessageCollection;
use App\Room\Entity\Message;


interface MessageRepositoryInterface
{
    public function create(Message $message): Message;

    public function getMessages($offset, $limit): MessageCollection;

    public function getMessagesByLastId($lastId): MessageCollection;
}
