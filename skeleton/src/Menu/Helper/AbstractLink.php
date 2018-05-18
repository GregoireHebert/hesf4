<?php


namespace App\Menu\Helper;


use App\Menu\LinkInterface;

abstract class AbstractLink implements LinkInterface
{
    public function getTarget(): string
    {
        return '_self';
    }
}
