<?php

declare(strict_types=1);

namespace App\Profile\Service;

use App\Profile\Entity\User;

interface RegisterUserServiceInterface
{
    /**
     * Регистрирует и создает пользователя
     *
     * @param User $user - незарегистрированный пользователь
     * @return User - зарегистрированный пользователь
     */
    public function register(User $user): User;
}
