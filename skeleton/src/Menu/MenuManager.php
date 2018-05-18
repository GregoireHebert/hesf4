<?php


namespace App\Menu;


use Doctrine\Common\Collections\ArrayCollection;

class MenuManager
{
    private $links;

    public function __construct()
    {
        $this->links = new ArrayCollection();
    }

    public function getMenu()
    {
        return $this->links;
    }

    public function addLink(LinkInterface $link)
    {
        if (!$this->links->contains($link)) {
            $this->links->add($link);
        }
    }
}
