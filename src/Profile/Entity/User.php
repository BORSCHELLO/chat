<?php

declare(strict_types=1);

namespace App\Profile\Entity;

use App\Profile\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use DateTimeImmutable;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20, nullable=false, unique=true)
     */
    private $name;
    /**
     * @ORM\Column(name="last_visit",type="datetime_immutable")
     */
    private $lastVisit;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return [
            'ROLE_USER'
        ];
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->getName();
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {

    }
    /**
     * @inheritDoc
     */
    public function getLastVisit(): ?DateTimeImmutable
    {
        return $this->lastVisit;
    }
    /**
     * @inheritDoc
     */
    public function setLastVisit(DateTimeImmutable $lastVisit)
    {
     $this->lastVisit=$lastVisit;
     return $this;
    }
}
