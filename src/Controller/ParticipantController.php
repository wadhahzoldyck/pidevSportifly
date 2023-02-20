<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\ParticipantType;
use App\Repository\UserRepository;
use App\Repository\EventRepository;
use App\Repository\ParticipantRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ParticipantController extends AbstractController
{
    #[Route('/participant', name: 'app_participant')]
    public function index(): Response
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'ParticipantController',
        ]);
    }

    #[Route('/listparticipants', name: 'app_listParticipants')]
    public function listParticipants(ParticipantRepository $repository)
    {
        $participants= $repository->findAll();
        return $this->render("participant/listeparticipants.html.twig",array("tabParticipants"=>$participants));

    }
    #[Route('/participer/{id}', name: 'app_participer')]
    public function participer(EventRepository $repository,$id,ManagerRegistry $doctrine,UserRepository $userRepo)
    {
        $idUser = 1;
        
        $user= $userRepo->find($idUser);
        $event = $repository->find($id);

        $participant = new Participant();
        $participant->setUser($user);
        $participant->setEvent($event);
        $participant->setDateParticipation(new \DateTime());

            $em = $doctrine->getManager();
            $em->persist($participant);
            $em->flush();
            return  $this->redirectToRoute("app_front");
        

    }

    
    #[Route('/updatePar/{id}', name: 'app_updatePar')]
    public function updateParticipant(ParticipantRepository $repository,$id,ManagerRegistry $doctrine,Request $request)
    {


        $participant= $repository->find($id);        
        $form=$this->createForm(ParticipantType::class,$participant);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            $em =$doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute("app_listParticipants");
        }
        return $this->renderForm("participant/add.html.twig",
            array("formParticipant"=>$form));
    }

    #[Route('/removePar/{id}', name: 'app_removePar')]
    public function deleteParticipant(ManagerRegistry $doctrine,$id,ParticipantRepository $repository)
    {
        $participant= $repository->find($id);
        $em= $doctrine->getManager();
        $em->remove($participant);
        $em->flush();
        return $this->redirectToRoute("app_listParticipants");

    }
}
