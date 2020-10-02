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

    public function testFindById()
    {
        $this->assertNull($this->userRepository->findById(1));
    }

    public function testFindByName()
    {
        $this->assertNull($this->userRepository->findByName('test'));
    }

    public function testCreate(){
        $date= new \DateTimeImmutable();
        $user = new User();
        $user->setName('test');
        $user->setLastVisit($date);

        $this->userRepository->create($user);

        $this->assertEquals(1, $user->getId());
        $this->assertEquals('test', $user->getName());
        $this->assertEquals($date->format('Y-m-d H:i:s'), $user->getLastVisit()->format('Y-m-d H:i:s'));
    }

}
