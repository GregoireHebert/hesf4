<?php

declare(strict_types=1);

namespace App\Controller;

use App\ChuckQuotes\ChuckNorrisQuoteRetriever;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/", name="myController")
 */
class MyController
{
    public function __invoke(LoggerInterface $logger, ChuckNorrisQuoteRetriever $quoteRetriever)
    {
        $logger->info("Mon log d'info");
        $escapedQuote = htmlentities($quoteRetriever->getRandomQuote());

        return new Response(<<<HTML
<html>
    <head><title>A Chuck Norris Fact</title></head>
    <body>
        <h1>Chuck!</h1>
        
        <p id="fact">$escapedQuote</p>
    </body>
</html>
HTML
        );
    }
}
