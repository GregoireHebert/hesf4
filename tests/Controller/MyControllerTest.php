<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\ChuckQuotes\ChuckNorrisQuoteRetriever;
use App\Controller\MyController;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Symfony\Component\HttpFoundation\Response;

class MyControllerTest extends TestCase
{
    private $loggerMock;
    private $quoteRetrieverMock;

    public function setUp()
    {
        $loggerMockBuilder = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()
            ->setMethods(['info']);

        $this->loggerMock = $loggerMockBuilder->getMock();
        $this->loggerMock->expects($this->once())->method('info')->with('Mon log d\'info');

        $quoteRetrieverMockBuilder = $this->getMockBuilder(ChuckNorrisQuoteRetriever::class)
            ->disableOriginalConstructor()
            ->setMethods(['getRandomQuote']);

        $this->quoteRetrieverMock = $quoteRetrieverMockBuilder->getMock();
        $this->quoteRetrieverMock
            ->expects($this->once())
            ->method('getRandomQuote')
            ->willReturn('ma chaine');
    }

    public function testInvoke(): void
    {
        $myController = new MyController();

        $response = $myController($this->loggerMock, $this->quoteRetrieverMock);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertContains('ma chaine', $response->getContent());

    }
}
