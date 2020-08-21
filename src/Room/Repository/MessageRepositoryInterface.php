<?php

declare(strict_types=1);

namespace App\Room\Repository;

use App\Room\Entity\Message;
use App\User\Entity\User;

interface MessageRepositoryInterface
{
    public function create(Message $message): ?Message;

    public function findByAll(): ?array;
}
