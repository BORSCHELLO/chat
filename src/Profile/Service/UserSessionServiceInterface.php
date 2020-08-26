<?php

declare(strict_types=1);

namespace App\Profile\Service;

use App\Profile\Entity\User;
use App\Profile\Repository\UserRepositoryInterface;
use DateTimeImmutable;

interface UserSessionServiceInterface
{
    public function getLastVisit(User $user): ?DateTimeImmutable;

    public function updateLastVisit(User $user): User;
}
