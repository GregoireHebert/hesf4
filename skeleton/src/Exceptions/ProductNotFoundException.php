<?php

declare(strict_types=1);

namespace App\Exceptions;

final class ProductNotFoundException extends \RuntimeException
{
    protected $message = 'The product does not exists.';
}
