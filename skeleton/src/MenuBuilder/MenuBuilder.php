<?php

declare(strict_types=1);

namespace App\MenuBuilder;

use App\Entity\PlacedOrder;
use App\Entity\Product;
use App\Entity\Selection;
use App\Exceptions\ProductNotFoundException;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;

final class MenuBuilder
{
    /** @var string */
    private $name = 'Anonymous';
    /** @var Selection[]|ArrayCollection */
    private $selections;

    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->reset();
        $this->productRepository = $productRepository;
    }

    public function reset(): void
    {
        $this->selections = new ArrayCollection();
        $this->name = null;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function addSelection(string $productName, int $quantity): self
    {
        if (null === $product = $this->productRepository->findOneBy(['name' => $productName])) {
            throw new ProductNotFoundException();
        }

        $existingSelections = $this->selections->filter(static function (Selection $selection) use ($product) {
           return $selection->getProduct() === $product;
        });

        if ($existingSelections->count() === 0) {
            $selection = new Selection();
            $selection->setProduct($product);
            $selection->setQuantity($quantity);

            $this->selections->add($selection);

            return $this;
        }

        /** @var Selection $selection */
        $selection = $existingSelections->first();
        $selection->setQuantity($selection->getQuantity()+$quantity);

        return $this;
    }

    public function createOrder(): PlacedOrder
    {
        $order = new PlacedOrder();
        $order->setName($this->name);
        $order->setStatus('preparing');
        $order->setSelections($this->selections);

        // @todo use validator

        $this->reset();

        return $order;
    }
}
