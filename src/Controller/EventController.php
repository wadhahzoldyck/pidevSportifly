<?php

namespace App\Controller;
use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    #[Route('/event', name: 'app_event')]
    public function index(): Response
    {
        return $this->render('event/index.html.twig', [
            'controller_name' => 'EventController',
        ]);
    }


    #[Route('/events', name: 'app_events')]

    public function listEvent(EventRepository $repository)
    {
        $events= $repository->findAll();
        return $this->render("event/listevent.html.twig",array("tabEvents"=>$events));
     
    }


    #[Route('/front', name: 'app_front')]

    public function listEventFront(EventRepository $repository)
    {
        $events= $repository->findAll();
        return $this->render("front/liste.html.twig",array("tabEvents"=>$events));
     }



    #[Route('/addevent', name: 'app_addevent')]
    public function addEvent(\Doctrine\Persistence\ManagerRegistry $doctrine,Request $request)
    {
        $event= new Event();
        $form= $this->createForm(EventType::class,$event);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em = $doctrine->getManager();
            $em->persist($event);
            $em->flush();
            return  $this->redirectToRoute("app_events");
        }
        return $this->renderForm("event/add.html.twig",
            array("formEvent"=>$form));
    }

    #[Route('/updateEvent/{id}', name: 'app_updateEvent')]
    public function updateEvent(EventRepository $repository,$id,ManagerRegistry $doctrine,Request $request)
    {
        $event= $repository->find($id);
        $form=$this->createForm(EventType::class,$event);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em =$doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute("app_events");
        }
        return $this->renderForm("event/add.html.twig",
            array("formEvent"=>$form));
    }

    #[Route('/removeEvent/{id}', name: 'app_removeEvent')]

    public function deleteEvent(ManagerRegistry $doctrine,$id,EventRepository $repository)
    {
        $event= $repository->find($id);
        $em= $doctrine->getManager();
        $em->remove($event);
        $em->flush();
        return $this->redirectToRoute("app_events");

    }
}
