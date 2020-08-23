<?php

declare(strict_types=1);

namespace Tests\Unit\App\User\Repository;

use App\Room\Entity\Message;
use App\Tests\Unit\DoctrineTestCase;

use App\Room\Repository\MessageRepositoryInterface;
use App\Profile\Entity\User;
use App\Profile\Repository\UserRepositoryInterface;

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
        $date = new \DateTimeImmutable();
        $z= new Message();
        $user->setName('test');

        $this->userRepository->create($user);

        $message = new Message();
        $message->setMessage('test');
        $message->setUser($user);
        $z->setCreatedAt($date);

        $this->messageRepository->create($message);

        $this->assertEquals('test', $message->getMessage());
        $this->assertEquals($date->format('Y-m-d H:i:s'), $z->getCreatedAt()->format('Y-m-d H:i:s'));
    }

}
