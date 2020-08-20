<?php

declare(strict_types=1);

namespace Tests\Unit\App\User\Repository;

use App\Tests\Unit\DoctrineTestCase;
use App\User\Entity\User;
use App\User\Repository\UserRepositoryInterface;

class UserTest extends DoctrineTestCase
{
    protected UserRepositoryInterface $userRepository;

    public function setUp()
    {
        parent::setUp();

        /** @var UserRepositoryInterface $userRepository */
        $this->userRepository = $this->em->getRepository(User::class);
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
