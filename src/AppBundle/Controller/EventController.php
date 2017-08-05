<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EventController extends Controller
{
    /**
     * @Route("/events", name="eventpage")
     */
    public function indexAction(Request $request)
    {

        $events = ['event1', 'event2'];
        return $this->render('default/event.html.twig', compact('events'));
    }

}
