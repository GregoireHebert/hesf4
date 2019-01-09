<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MyControllerFunctionnalTest extends WebTestCase
{
    public function testInvoke()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertContains('A Chuck Norris Fact', $crawler->filter('head title')->text());
        $this->assertContains('Chuck!', $crawler->filter('h1')->text());
        $this->assertContains('Chuck Norris', $crawler->filter('p#fact')->text());
    }
}
