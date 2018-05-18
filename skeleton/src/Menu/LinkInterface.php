<?php

declare(strict_types=1);

namespace App\Menu;

interface LinkInterface
{
    /**
     * @return string
     */
    public function getRoute(): string;

    /**
     * @return string
     */
    public function getLabel(): string;

    /**
     * @return string
     */
    public function getTarget(): string;
}
