<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"Book:read"}}
 * )
 * @ORM\Entity
 */
final class Book
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups("Book:read")
     */
    public $id;
    /**
     * @ORM\Column
     * @Groups("Book:read")
     */
    public $title;
    /**
     * @ORM\Column
     */
    public $description;
    /**
     * @ORM\Column
     */
    public $author;
}
