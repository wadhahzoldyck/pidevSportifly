<?php

namespace App\Controller;

use App\Entity\Actualite;
use App\Form\ActualiteType;
use App\Repository\ActualiteRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActualiteController extends AbstractController
{
    #[Route('/actualite', name: 'app_actualite')]
    public function afficheractualite(ActualiteRepository $repository)
    {   $actualite=$repository->findAll();
        return $this->render('actualite/index.html.twig', array("form"=>$actualite));
    }

    #[Route('/ajouteractualite', name: 'app_ajouteractualite')]
    public function ajouterActualite(Request $request,ManagerRegistry $doctrine): Response
    {    $actualite=new Actualite();
        $form=$this->createForm(ActualiteType::class,$actualite);
        $form->handleRequest($request);
            if($form->isSubmitted()&&$form->isValid()){


                $em =$doctrine->getManager() ;
                $em->persist($actualite);
                $em->flush();
                return $this->redirectToRoute("app_actualite");
        }
            return $this->renderForm('actualite/ajouter.html.twig', array("form"=>$form));
    }

    #[Route('/updateactualite/{id}', name: 'app_apdateactualite')]
    public function updateActualite(ActualiteRepository $repository,$id,ManagerRegistry $doctrine,Request $request)
    {    $actualite=$repository->find($id);
        $form=$this->createForm(ActualiteType::class,$actualite);
        $form->handleRequest($request);
        if($form->isSubmitted()){


            $em =$doctrine->getManager() ;
            $em->flush();
            return $this->redirectToRoute("app_actualite");
        }
        return $this->renderForm('actualite/update.html.twig', array("form"=>$form));
    }
    #[Route('/supprimeractualite/{id}', name: 'app_supprimeractualite')]
    public function supprimerActualite(ActualiteRepository $repository,$id,ManagerRegistry $doctrine)
    {    $actualite=$repository->find($id);
        $form=$this->createForm(ActualiteType::class,$actualite);
            $em =$doctrine->getManager() ;
            $em->remove($actualite);
            $em->flush();
            return $this->redirectToRoute("app_actualite");

    }
}
