<?php

declare(strict_types=1);

namespace App\Profile\Repository;

use App\Profile\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface, UserLoaderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findByName(string $name): ?User
    {
        return $this->findOneBy(['name' => $name]);
    }

    public function findById(int $id): ?User
    {
        return $this->find(['id'=>$id]);
    }

    public function create(User $user): User
    {
        $this->_em->persist($user);
        $this->_em->flush();

        return $user;
    }

    public function loadUserByUsername(string $username)
    {
        return $this->findByName($username);
    }
}
