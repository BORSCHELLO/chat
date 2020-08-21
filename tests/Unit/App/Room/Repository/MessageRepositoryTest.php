<?php

declare(strict_types=1);

namespace Tests\Unit\App\User\Repository;

use App\Room\Entity\Message;
use App\Tests\Unit\DoctrineTestCase;

use App\Room\Repository\MessageRepositoryInterface;
use App\User\Entity\User;
use App\User\Repository\UserRepositoryInterface;

class MessageRepositoryTest extends DoctrineTestCase
{
    protected MessageRepositoryInterface $messageRepository;

    protected UserRepositoryInterface $userRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->messageRepository = $this->em->getRepository(Message::class);
        $this->userRepository = $this->em->getRepository(User::class);
    }

    public function testFindAll()
    {
        $user=new User();
        $user->setName('test');
        $this->userRepository->create($user);

        $message = new Message();
        $message->setMessage('test');
        $message->setCreatedAt('2020-08-21 17:18:09');
        $message->setUser($user);

        $this->messageRepository->create($message);

        $this->assertEquals('test', $message->getMessage());
        $this->assertEquals('2020-08-21 17:18:09', $message->getCreatedAt());
    }

}
