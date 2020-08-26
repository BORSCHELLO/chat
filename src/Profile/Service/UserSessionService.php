<?php

declare(strict_types=1);

namespace App\Profile\Service;

use App\Profile\Entity\User;
use App\Profile\Repository\UserRepositoryInterface;
use DateTimeImmutable;

class UserSessionService implements UserSessionServiceInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getLastVisit(User $user): ?DateTimeImmutable
    {
        return $user->getLastVisit();
    }

    public function updateLastVisit(User $user): User
    {
        $date=new DateTimeImmutable();
        $user->setLastVisit($date);
        $this->userRepository->update($user);

        return $user;
    }
}