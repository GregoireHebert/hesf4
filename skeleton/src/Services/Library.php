<?php

declare(strict_types=1);

namespace App\Services;

/**
 * @author Grégoire Hébert <gregoire@les-tilleuls.coop>
 */
class Library
{
    // this is a service because autowiring automatically register it.
    // run docker-compose exec app bin/console debug:container Library

    // now run docker-compose exec app bin/console debug:autowiring

    public function takeBook()
    {
        $books = [
            'Tintin au congo',
            'Tintin - le lac aux requins',
            'Tintin - les 7 boules de cristal',
        ];

        return $books[array_rand($books)];
    }
}
