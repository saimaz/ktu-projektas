<?php
namespace KTU\AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $count = $crawler->filter('h1:contains("Hello")')->count();
        $this->assertEquals(1, $count);
    }
} 