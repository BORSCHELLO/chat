<?php

declare(strict_types=1);

namespace App\Profile\Service;

use App\Profile\Entity\User;
use App\Profile\Repository\UserRepositoryInterface;

class RegisterUserService implements RegisterUserServiceInterface
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @inheritDoc
     */
    public function register(User $user): User
    {
        return $this->userRepository->create($user);
    }
}
