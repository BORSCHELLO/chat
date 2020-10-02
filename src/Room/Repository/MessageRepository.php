<?php

namespace App\Room\Repository;

use App\Room\Collection\MessageCollection;
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

    public function getMessages($offset, $limit): MessageCollection
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager
            ->createQuery("SELECT u FROM App\Room\Entity\Message u ORDER BY u.id DESC")
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        return new MessageCollection($query->getResult());
    }

    public function getMessagesByLastId($lastId): MessageCollection
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager
            ->createQuery("SELECT u FROM App\Room\Entity\Message u WHERE u.id > :lastId ORDER BY u.id DESC");
        $query->setParameter('lastId',$lastId);

        return new MessageCollection($query->getResult());
    }

}
