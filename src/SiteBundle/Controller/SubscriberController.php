<?php

namespace SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

//entity
use SiteBundle\Entity\Subscriber;
use SiteBundle\Form\SubscriberType;

class SubscriberController extends Controller
{
    public function subscribeAction(request $request)
    {
    	$em =$this->getDoctrine()->getManager();
      
      $name = $request->get('name');
      $mail = $request->get('mail');


      $subscriber = new Subscriber();
      $subscriber
        ->setName($name)
        ->setMail($mail)
      ;
      $em->persist($subscriber);
      $em->flush();

      $request->getSession()->getFlashBag()->add('success', 'Dank u voor het inschrijven voor de nieuwsletter.');

      return new response();
    }
}
