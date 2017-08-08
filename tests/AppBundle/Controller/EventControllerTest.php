<?php

namespace Tests\AppBundle\Controller;


use AppBundle\Entity\Event;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Config\Definition\Exception\Exception;

class EventControllerTest extends WebTestCase
{

    private $client;
    private $container;
    private $em;
    private $crawler;

    protected function setUp()
    {
        parent::setUp();


        $this->client = static::createClient();

        $this->container = $this->client->getContainer();
        $this->em = $this->container->get('doctrine')->getManager();

//first method
        static $metaData;
        if (!isset($metaData)) {
            $metaData = $this->em->getMetadataFactory()->getAllMetadata();
        }

        $schemaTool = new SchemaTool($this->em);
        $schemaTool->dropDatabase();

        if (!empty($metaData)) {
            $schemaTool->createSchema($metaData);
        }


        //second method
//        $this->em->beginTransaction();
//        $this->em->getConnection()->setAutoCommit(false);


    }

    public function testindex_should_list_all_events()
    {
        $client = static::createClient();

//        $container = $client->getContainer();
//        $em = $container->get('doctrine')->getManager();


        $entities = $this->em->getRepository('AppBundle:Event')->findAll();
        $init = count($entities);
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

        $this->em->persist($event);
        $this->em->persist($event1);
        $this->em->flush();

        $entities = $this->em->getRepository('AppBundle:Event')->findAll();
        $final = count($entities);


        $this->assertEquals($init + 2, $final);


        $this->crawler = $client->request('GET', '/events');

//        try {
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Test', $client->getResponse()->getContent());

//        } catch (\Exception $e) {
//            dump(get_class($e));
//            dump($e->getMessage());
//            dump($crawler->filter('.exception-message')->text());
//            die;
//        }
//        $this->assertContains('event2', $client->getResponse()->getContent());
    }

    protected function onNotSuccessfulTest(\Throwable $t)
    {

        if ($this->crawler && $this->crawler->filter('.exception-message')->count() > 0) {

            $throwabale = get_class($t);

            throw new $throwabale($t->getMessage() . '|' . $this->crawler->filter('.exception-message')->text());
        }

        throw $t;
    }

    protected function tearDown()
    {
        parent::tearDown();

//        $this->em->rollback();

        $this->em->close();
        $this->em = null;
    }
}