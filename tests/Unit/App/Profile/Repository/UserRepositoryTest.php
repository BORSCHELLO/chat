<?php

declare(strict_types=1);

namespace Tests\Unit\App\User\Repository;

use App\Tests\Unit\DoctrineTestCase;
use App\Profile\Entity\User;
use App\Profile\Repository\UserRepositoryInterface;

class UserRepositoryTest extends DoctrineTestCase
{
    protected UserRepositoryInterface $userRepository;

    public function setUp(): void
    {
        parent::setUp();

        /** @var UserRepositoryInterface $userRepository */
        $this->userRepository = $this->em->getRepository(User::class);
    }

    public function testFindById(){
        $this->assertNull($this->userRepository->findById(1));

        $user = new User();
        $user->setName('test');

        $this->userRepository->create($user);

        $this->assertEquals(1, $user->getId());
    }

    public function testCreateFind()
    {
        $this->assertNull($this->userRepository->findByName('test'));

        $user = new User();
        $user->setName('test');

        $this->userRepository->create($user);

        $this->assertEquals(1, $user->getId());
        $this->assertEquals('test', $user->getName());
    }
}
