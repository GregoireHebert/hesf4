<?php

declare(strict_types=1);

namespace App\ChuckQuotes;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class ChuckNorrisQuoteRetriever
{
    private const QUOTES = [
        'en' => [
            'Chuck Norris can draw cash from ATMs using UNO cards.',
            'People look up at the moon, while the moon looks down at Chuck Norris.',
        ],
        'fr' => [
            'Chuck Norris peut retirer aux distributeurs de billets avec des cartes de UNO.',
            'Les gens regardent la lune, pendant que la lune regarde Chuck Norris.',
        ],
    ];

    private $logger;
    private $locale;

    public function __construct(LoggerInterface $logger, string $locale = 'en')
    {
        $this->logger = $logger;
        $this->locale = $locale;
    }

    public function getRandomQuote(): string
    {
        $quote = self::QUOTES[$this->locale][array_rand(self::QUOTES[$this->locale])];
        $this->logger->info('La citation retournée est {quote}', ['quote' => $quote]);

        return $quote;
    }
}
