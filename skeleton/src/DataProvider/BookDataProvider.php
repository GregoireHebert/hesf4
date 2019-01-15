<?php

declare(strict_types=1);

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use App\Entity\Book;

class BookDataProvider implements CollectionDataProviderInterface, RestrictedDataProviderInterface, ItemDataProviderInterface
{
    private $books = [];

    public function __construct()
    {
        $book = new Book();
        $book->id = 1;
        $book->author = 'Hergé';
        $book->title = 'Tintin objectif Lune';
        $book->description = 'Un journaliste et son chien vont dans l\'espace';

        $this->books[1] = $book;

        $book = new Book();
        $book->id = 2;
        $book->author = 'Hergé';
        $book->title = 'Coke en stock';
        $book->description = 'Un journaliste et son chien se défoncent';

        $this->books[2] = $book;
    }

    public function getCollection(string $resourceClass, string $operationName = null)
    {
        return $this->books;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return $resourceClass === Book::class;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        return $this->books[$id] ?? null;
    }
}
