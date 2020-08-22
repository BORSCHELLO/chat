<?php

declare(strict_types=1);

namespace App\Profile\Repository;

use App\Profile\Entity\User;

interface UserRepositoryInterface
{
    public function create(User $user): User;

    public function findByName(string $name): ?User;

    public function findById(int $id): ?User;
}
