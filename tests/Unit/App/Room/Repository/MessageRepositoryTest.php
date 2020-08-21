<?php

declare(strict_types=1);

namespace Tests\Unit\App\User\Repository;

use App\Room\Entity\Message;
use App\Tests\Unit\DoctrineTestCase;

use App\Room\Repository\MessageRepositoryInterface;
use App\User\Entity\User;

class MessageRepositoryTest extends DoctrineTestCase
{
    protected MessageRepositoryInterface $messageRepository;

    public function setUp(): void
    {
        parent::setUp();

        /** @var MessageRepositoryInterface $messageRepository */
        $this->messageRepository = $this->em->getRepository(Message::class);
    }

    public function testFindAll()
    {
        $message = new Message();
        $user=new User();

        $message->setMessage('test');
        $message->setCreatedAt('2020-08-21 17:18:09');
        $user->setName('test');
        $message->setUser($user->getId());



        $this->messageRepository->create($message);

        $this->assertEquals('test', $message->getMessage());
        $this->assertEquals('2020-08-21 17:18:09', $message->getCreatedAt());
    }

}
