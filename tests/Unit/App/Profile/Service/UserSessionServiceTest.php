<?php

declare(strict_types=1);

namespace Tests\Unit\App\User\Repository;

use App\Tests\Unit\DoctrineTestCase;
use App\Profile\Entity\User;
use App\Profile\Repository\UserRepositoryInterface;
use DateTimeImmutable;

class UserSessionServiceTest extends DoctrineTestCase
{
    protected UserRepositoryInterface $userRepository;

    public function setUp(): void
    {
        parent::setUp();

        /** @var UserRepositoryInterface $userRepository */
        $this->userRepository = $this->em->getRepository(User::class);
    }

    public function testGetLastVisit()
    {

        $user=new User;
        $date = new DateTimeImmutable();
        $this->assertNull($user->getLastVisit());
        $user->setLastVisit($date);

        $this->assertEquals($date->format('Y-m-d H:i:s'), $user->getLastVisit()->format('Y-m-d H:i:s'));
    }

    public function testUpdateLastVisit()
    {

        $user=new User();
        $date = new DateTimeImmutable();
        $this->assertNull($user->getLastVisit());
        $user->setLastVisit($date);

        $this->userRepository->update($user);

        $this->assertEquals($date->format('Y-m-d H:i:s'), $user->getLastVisit()->format('Y-m-d H:i:s'));
    }
}
