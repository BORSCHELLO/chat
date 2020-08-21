<?php

namespace App\Room\Repository;

use App\Room\Entity\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class MessageRepository extends ServiceEntityRepository implements MessageRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    public function create(Message $message): Message
    {
        $this->_em->persist($message);
        $this->_em->flush();

        return $message;
    }

    public function findByAll(): ?array
    {
        return $this->findAll();
    }
}
