<?php

declare(strict_types=1);

namespace App\Entity;

use App\Validator\Constraints\Past;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Assert\
 */
final class Contact
{
    /**
     * @Assert\NotBlank
     */
    private $name = '';
    /**
     * @Assert\NotBlank
     * @Assert\DateTime
     * @Past
     */
    private $birth;
    /**
     * @Assert\NotBlank
     * @Assert\Email
     */
    private $email = '';
    /**
     * @Assert\NotBlank
     */
    private $title = '';
    /**
     * @Assert\NotBlank
     * @Assert\Length(min="10")
     */
    private $body = '';

    public function __construct()
    {
        $this->birth = new \DateTime();
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getBirth(): ?\DateTimeInterface
    {
        return $this->birth;
    }

    /**
     * @param \DateTimeInterface $birth
     */
    public function setBirth(\DateTimeInterface $birth): void
    {
        $this->birth = $birth;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }
}
