<?php

declare(strict_types=1);

namespace Tests\Unit\App\User\Repository;

use App\Room\Entity\Message;
use App\Tests\Unit\DoctrineTestCase;

use App\Room\Repository\MessageRepositoryInterface;

class MessageRepositoryTest extends DoctrineTestCase
{
    protected MessageRepositoryInterface $messageRepository;

    public function setUp(): void
    {
        parent::setUp();

        /** @var MessageRepositoryInterface $messageRepository */
        $this->messageRepository = $this->em->getRepository(Message::class);
    }

    public function testFindAll(){
        $this->assertNull($this->messageRepository->findAll());

        $message = new Message();
        $message->setMessage('test');

        $this->messageRepository->create($message);

        $this->assertEquals('test', $message->getMessage());
    }

}
