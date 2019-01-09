<?php

declare(strict_types=1);

namespace App\Tests\ChuckQuotes;

use App\ChuckQuotes\ChuckNorrisQuoteRetriever;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

class ChuckNorrisQuoteRetrieverTest extends TestCase
{
    private $loggerMock;

    public function setUp()
    {
        $loggerMockBuilder = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()
            ->setMethods(['info']);

        $this->loggerMock = $loggerMockBuilder->getMock();
        $this->loggerMock->expects($this->once())->method('info');
    }

    public function tearDown()
    {
        // ...
    }

    public function testQuoteContainsChuckNorrisInEN(): void
    {
        $quoteRetriever = new ChuckNorrisQuoteRetriever($this->loggerMock);

        $this->assertContains('Chuck Norris',  $quoteRetriever->getRandomQuote());
    }

    public function testQuoteContainsChuckNorrisInFR(): void
    {
        $quoteRetriever = new ChuckNorrisQuoteRetriever($this->loggerMock, 'fr');

        $this->assertContains('Chuck Norris',  $quoteRetriever->getRandomQuote());
    }
}
