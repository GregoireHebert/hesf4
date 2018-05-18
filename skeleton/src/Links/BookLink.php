<?php


namespace App\Links;

use App\Menu\Helper\AbstractLink;
use App\Menu\LinkInterface;

class BookLink extends AbstractLink
{
    public function getRoute(): string
    {
        return 'app_booksaction__invoke';
    }

    public function getLabel(): string
    {
        return 'Liste des livres';
    }
}
