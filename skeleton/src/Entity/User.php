<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
//use Symfony\Component\Security\Core\User\AdvancedUserInterface;


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 *
 * @author Grégoire Hébert <gregoire@les-tilleuls.coop>
 */
class User implements UserInterface
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(unique=true)
     */
    private $username;

    /**
     * @var string
     * @ORM\Column(unique=true)
     */
    private $password;

    /**
     * @var \DateTimeImmutable
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastConnexion;

    public function __construct($username)
    {
        $this->setUsername($username);
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getLastConnexion(): \DateTimeImmutable
    {
        return $this->lastConnexion;
    }

    /**
     * @param \DateTimeImmutable $lastConnexion
     */
    public function setLastConnexion(\DateTimeImmutable $lastConnexion): void
    {
        $this->lastConnexion = $lastConnexion;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getRoles(): array
    {
        return ['ROLE_USER', 'ROLE_ALLOWED_TO_SWITCH', 'ROLE_SUPER_ADMIN'];
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    public function getSalt()
    {
    }

    public function eraseCredentials(): void
    {
    }
}
