<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Entity\Reservation;
use App\Entity\User;

use App\Repository\OffreRepository;
use App\Repository\ReservationRepository;

use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'app_reservation')]
    public function index(): Response
    {
        return $this->render('reservation/index.html.twig', [
            'controller_name' => 'ReservationController',
        ]);
    }

    #[Route('/reserveroffre/{id}', name: 'app_reserverOffre')]
    public function ReserverOffre($id, ManagerRegistry $doctrine , Request $request , OffreRepository $rep, UserRepository $rep2){
        $user = new User();
        $offre = new Offre();
        $offre = $rep->find($id);
        $user = $rep2->find(2);

        $reservation = new Reservation();
            $reservation->setIdUser($user);
            $reservation->setIdOffre($offre);
            $reservation->setDate(new \DateTime('now') ) ;
            $em = $doctrine->getManager();
            $em->persist($reservation);
            $em->flush();
            return $this->redirectToRoute('app_listoffre');

    }






    #[Route('/reserveroffrefront/{id}', name: 'app_reserverOffrefront')]
    public function ReserverOffre1($id, ManagerRegistry $doctrine , Request $request , OffreRepository $rep, UserRepository $rep2){
        $user = new User();
        $offre = new Offre();
        $offre = $rep->find($id);
        $user = $rep2->find(2);

        $reservation = new Reservation();
        $reservation->setIdUser($user);
        $reservation->setIdOffre($offre);
        $reservation->setDate(new \DateTime('now') ) ;
        $em = $doctrine->getManager();
        $em->persist($reservation);
        $em->flush();
        return $this->redirectToRoute('app_listreservationfront');

    }


    //BACKOFFICE
    #[Route('admin/reservation/listreservation', name: 'app_listreservation')]
    public function affRes( ReservationRepository $repository  ): Response
    {   $user=$repository->getuser();
        $offre = $repository->getOffre();
        $reservation =$repository->findAll();
        return $this->render('reservation/listres.html.twig', [
            'reservation' => $reservation ,
            'offre' => $offre,'user'=>$user
        ] );
    }



    #[Route('/reservation/listreservationfront', name: 'app_listreservationfront')]
    public function affResById( ReservationRepository $repository , UserRepository $rep2  ): Response
    {
        $user = new User();
        $user= $rep2->find(2);



        $offre =$repository->getOffreById(2);
        $reservation =$repository->findBy(['id_user'=>$user]);
        return $this->render('reservation/listresfront.html.twig', [
            'reservation' => $reservation ,
            'offre' => $offre
        ] );
    }

    #[Route('/reservation/listreservationcoach', name: 'app_listreservationcoach')]
    public function affResByIdCoach( ReservationRepository $repository , UserRepository $rep2  ): Response
    {
        $user = new User();
        $user= $rep2->find(2);



        $offre =$repository->getOffreById(2);
        $reservation =$repository->findBy(['id_user'=>$user]);
        return $this->render('reservation/listresfrontcoach.html.twig', [
            'reservation' => $reservation ,
            'offre' => $offre
        ] );
    }


    #[Route('/removeFront/{id}', name: 'app_removeFront')]

    public function deleteRes(ManagerRegistry $doctrine,$id,ReservationRepository  $repository)
    {
        $res= $repository->find($id);
        $em= $doctrine->getManager();
        $em->remove($res);
        $em->flush();
        return $this->redirectToRoute("app_listreservationfront");

    }
    #[Route('/removeback/{id}', name: 'app_removeback')]

    public function deleteres1(ManagerRegistry $doctrine,$id,ReservationRepository  $repository)
    {
        $offre= $repository->find($id);
        $em= $doctrine->getManager();
        $em->remove($offre);
        $em->flush();
        return $this->redirectToRoute("app_listreservation");

    }
}
