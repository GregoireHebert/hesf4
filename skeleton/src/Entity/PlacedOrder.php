<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
final class PlacedOrder
{
    public const STATUS_PREPARING = 'Preparing';
    public const STATUS_READY = 'Ready';
    public const STATUS_TAKEN = 'Taken';

    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $number;

    /**
     * @var string
     * @ORM\Column
     *
     * @Assert\NotBlank
     * @Assert\Length(min=1)
     * @Assert\Type(type="string")
     */
    private $name;

    /**
     * @var Selection[]|Collection
     * @ORM\ManyToMany(targetEntity=Selection::class, cascade={"persist"})
     * @ORM\JoinTable(
     *     name="placed_order_selection",
     *     joinColumns={@ORM\JoinColumn(name="placed_order_id", referencedColumnName="number")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="selection_id", referencedColumnName="id", unique=true)}
     * )
     * @Assert\NotBlank
     * @Assert\All({
     *     @Assert\Type(type=Selection::class)
     * })
     */
    private $selections;

    private $total;

    /**
     * @var string
     * @ORM\Column
     * @Assert\NotBlank
     * @Assert\Type(type="string")
     * @Assert\Choice({"Preparing", "Ready", "Taken"})
     */
    private $status;

    public function __construct()
    {
        $this->selections = new ArrayCollection();
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): void
    {
        $this->number = $number;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return Selection[]|Collection|null
     */
    public function getSelections(): ?Collection
    {
        return $this->selections;
    }

    /**
     * @param Selection[]|Collection $selections
     */
    public function setSelections($selections): void
    {
        $this->selections = $selections;
    }

    public function addSelection(Selection $selection): void
    {
        if (!$this->selections->contains($selection)) {
            $this->selections->add($selection);
        }
    }

    public function removeSelection(Selection $selection): void
    {
        if ($this->selections->contains($selection)) {
            $this->selections->removeElement($selection);
        }
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        if (!in_array($status, [self::STATUS_PREPARING, self::STATUS_READY, self::STATUS_TAKEN], true)) {
            throw new \InvalidArgumentException('Unsupported Status');
        }

        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @return mixed
     */
    public function getRoundedTotal()
    {
        return $this->total/100;
    }

    /**
     * @param mixed $total
     */
    public function setTotal($total): void
    {
        $this->total = $total;
    }
}
