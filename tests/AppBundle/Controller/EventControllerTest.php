<?php

namespace Tests\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EventControllerTest extends WebTestCase
{


    public function testindex_should_list_all_events()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/events');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('event1', $client->getResponse()->getContent());
        $this->assertContains('event2', $client->getResponse()->getContent());
    }
}