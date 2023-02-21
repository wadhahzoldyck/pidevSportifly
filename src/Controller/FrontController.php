<?php

namespace App\Controller;

use App\Entity\Actualite;
use App\Form\ActualiteType;
use App\Entity\CommentaireAct;
use App\Form\CommentaireActType;
use App\Repository\ActualiteRepository;
use App\Repository\CommentaireActRepository;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    #[Route('/front', name: 'app_front')]
    public function affichage(ActualiteRepository $actualiteRepository, CommentaireActRepository $commentaireRepository): Response
    {
        // Récupérer toutes les actualités
        $actualites = $actualiteRepository->findAll();

        // Récupérer tous les commentaires associés à chaque actualité
        $commentairesParActualite = [];
        foreach ($actualites as $actualite) {
            $commentaires = $commentaireRepository->findBy(['id_actualite' => $actualite->getId()]);
            $commentairesParActualite[$actualite->getId()] = $commentaires;
        }

        return $this->render('front/index.html.twig', [
            'actualites' => $actualites,
            'commentairesParActualite' => $commentairesParActualite
        ]);
    }

    #[Route('/ajouterCom/{id}', name: 'app_ajouterCom')]
    public function ajoutercommentaire(ActualiteRepository $repository,$id,Request $request,ManagerRegistry $doctrine): Response
    {
        $comment = new CommentaireAct();
        $form = $this->createForm(CommentaireActType::class, $comment);
        $actualite=$repository->find($id);
        $comment->setIdActualite($actualite);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($comment);
            $em->flush();
            return $this->redirectToRoute("app_front");
        }
        return $this->renderForm('front/ajouterCom.html.twig', array("form" => $form));
    }
    #[Route('/updateCom/{id}', name: 'app_updateCom')]
    public function updateCommentaire(CommentaireActRepository $repository,$id,ManagerRegistry $doctrine,Request $request)
    {
        $comment = $repository->find($id);
        $form = $this->createForm(CommentaireActType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            $em = $doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute("app_front");
        }
        return $this->renderForm('front/updateCom.html.twig', array("form"=>$form));
    }
    #[Route('/supprimerCom/{id}', name: 'app_supprimerCom')]
    public function supprimerComment(CommentaireActRepository $repository,$id,ManagerRegistry $doctrine)
    {    $comment=$repository->find($id);
        $form=$this->createForm(CommentaireActType::class,$comment);
        $em =$doctrine->getManager() ;
        $em->remove($comment);
        $em->flush();
        return $this->redirectToRoute("app_front");

    }

}
