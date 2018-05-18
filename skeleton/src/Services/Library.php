<?php

declare(strict_types=1);

namespace App\Services;
use Psr\Log\LoggerInterface;

/**
 * @author Grégoire Hébert <gregoire@les-tilleuls.coop>
 */
class Library
{
    private $logger;
    private $stringArg;

    public function __construct(LoggerInterface $logger, $stringArg)
    {
        $this->logger = $logger;
        $this->stringArg = $stringArg;
    }

    public function takeBook()
    {
        $books = [
            'Tintin au congo',
            'Tintin - le lac aux requins',
            'Tintin - les 7 boules de cristal',
        ];

        $book = $books[array_rand($books)];
        $this->logger->notice("borrowed book $book");

        return $book;
    }
}
