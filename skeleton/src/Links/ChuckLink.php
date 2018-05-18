<?php


namespace App\Links;

use App\Menu\Helper\AbstractLink;
use App\Menu\LinkInterface;

class ChuckLink extends AbstractLink
{
    public function getRoute(): string
    {
        return 'app_chucknorris__invoke';
    }

    public function getLabel(): string
    {
        return 'chuck';
    }

    public function getTarget(): string
    {
        return 'blank';
    }

}
