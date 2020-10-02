<?php

declare(strict_types=1);

namespace Tests\Unit\App\User\Repository;

use App\Room\Entity\Message;
use App\Room\Repository\MessageRepository;
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

    private function createUser(): User
    {
        $date = new \DateTimeImmutable();
        $user = new User();
        $user->setName('test');
        $user->setLastVisit($date);

        $this->userRepository->create($user);

        return $user;
    }

    public function testCreate()
    {
        $user = $this->createUser();

        $date = new \DateTimeImmutable();

        $message = new Message();
        $message->setMessage('test');
        $message->setUser($user);
        $message->setCreatedAt($date);

        $this->messageRepository->create($message);

        $this->assertEquals(1, $message->getId());
        $this->assertEquals('test', $message->getMessage());
        $this->assertEquals('test', $user->getName());
        $this->assertEquals($user, $message->getUser());
        $this->assertEquals($date->format('Y-m-d H:i:s'), $message->getCreatedAt()->format('Y-m-d H:i:s'));
    }

    public function testGetMessages()
    {
        $user = $this->createUser();

        $messages = [];

        foreach (range(1, 3) as $i) {
            $message = new Message();
            $message->setMessage('test' . $i);
            $message->setUser($user);
            $message->setCreatedAt(new \DateTimeImmutable());
            $this->messageRepository->create($message);

            $messages[] = $message;
        }

        $collection = $this->messageRepository->getMessages(0, 0);
        $this->assertEmpty($collection);

        $collection = $this->messageRepository->getMessages(0, 2);
        $this->assertCount(2, $collection);
        $this->assertSame($collection->get(0), $messages[2]);
        $this->assertSame($collection->get(1), $messages[1]);

        $collection = $this->messageRepository->getMessages(2, 2);

        $this->assertCount(1, $collection);
        $this->assertSame($collection->get(0), $messages[0]);
    }

    public function testGetMessagesByLastId()
    {
        $user = $this->createUser();

        $messages = [];

        foreach (range(1, 3) as $i) {
            $message = new Message();
            $message->setMessage('test' . $i);
            $message->setUser($user);
            $message->setCreatedAt(new \DateTimeImmutable());
            $this->messageRepository->create($message);

            $messages[] = $message;
        }

        $lastId = $messages[2]->getId();
        $collection = $this->messageRepository->getMessagesByLastId($lastId);
        $this->assertEmpty($collection);

        $lastId = $messages[0]->getId();
        $collection = $this->messageRepository->getMessagesByLastId($lastId);
        $this->assertCount(2, $collection);
        $this->assertSame($collection->get(1), $messages[1]);
        $this->assertSame($collection->get(0), $messages[2]);

        $lastId = $messages[1]->getId();
        $collection = $this->messageRepository->getMessagesByLastId($lastId);
        $this->assertCount(1, $collection);
        $this->assertSame($collection->get(0), $messages[2]);
    }
}
