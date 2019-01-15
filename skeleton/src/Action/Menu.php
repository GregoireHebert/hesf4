<?php

namespace App\Action;

use App\Menu\MenuManager;
use Symfony\Component\Routing\Annotation\Route;

class Menu
{
    /**
     * @Route("/menu.{_format}", name="menu", defaults={"_format": "html"})
     */
    public function __invoke(MenuManager $menuManager)
    {
        return $menuManager->getMenu();
    }
}
