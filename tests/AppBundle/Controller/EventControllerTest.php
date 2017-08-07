<?php

namespace Tests\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EventControllerTest extends WebTestCase
{


    public function testindex_should_list_all_events()
    {
        $client = static::createClient();

        $container = $client->getContainer();
//$container = static ::$karnel->getContainer();
        $event = new Event();
        $event->setName('Test MVC');
        $event->setLocation('tunisie');
        $event->setPrice(22);

        $event1 = new Event();
        $event1->setName('Test Cloud');
        $event1->setLocation('france');
        $event1->setPrice(25);

//        $em = $this->getDoctrine()->getManager();

        $em = $container->get('doctrine')->getManager();
        $em->persist($event);
        $em->persist($event1);
        $em->flush();




        $crawler = $client->request('GET', '/events');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('event1', $client->getResponse()->getContent());
        $this->assertContains('event2', $client->getResponse()->getContent());
    }
}