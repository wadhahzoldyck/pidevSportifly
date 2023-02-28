<?php

namespace App\Controller;

use App\Entity\Actualite;
use App\Entity\User;
use App\Form\ActualiteType;
use App\Entity\CommentaireAct;
use App\Form\CommentaireActType;
use App\Repository\ActualiteRepository;
use App\Repository\CommentaireActRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;


class FrontController extends AbstractController
{
    #[Route('/front', name: 'app_front')]
    public function affichage(ActualiteRepository $actualiteRepository, CommentaireActRepository $commentaireRepository): Response
    {
        // Récupérer toutes les actualités
        $actualites = $actualiteRepository->findAll();

        // Récupérer tous les commentaires associés à chaque actualité
        //$commentairesParActualite = [];
        //foreach ($actualites as $actualite) {
          //  $commentaires = $commentaireRepository->findBy(['id_actualite' => $actualite->getId()]);
            //$commentairesParActualite[$actualite->getId()] = $commentaires;
        //}

        return $this->render('front/newspage.html.twig', [
            'actualites' => $actualites
          //  ,'commentairesParActualite' => $commentairesParActualite
        ]);
    }

    #[Route('/ajouterCom/{id}', name: 'app_ajouterCom')]
    public function ajoutercommentaire(ActualiteRepository $repository, $id, Request $request, EntityManagerInterface $em,UserRepository $userRepository): Response
    {$user=new User();
        $user=$userRepository->find(1);
        $comment = new CommentaireAct();
        $form = $this->createForm(CommentaireActType::class, $comment);

        $actualite = $repository->find($id);
        $comment->setIdActualite($actualite);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setIdUser($user);
            $em->persist($comment);
            $em->flush();
            return $this->redirectToRoute("app_ajouterCom",array('id'=>$id));
        }

        return $this->render('front/ajouterCom.html.twig', array(
            "form" => $form->createView(),
            "actualite" => $actualite
        ));
    }

    #[Route('/updateCom/{id}/{id2}', name: 'app_updateCom')]
    public function updateCommentaire(CommentaireActRepository $repository, $id,$id2, ManagerRegistry $doctrine, Request $request)
    {
        $comment = $repository->find($id);
        $form = $this->createForm(CommentaireActType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            $em = $doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute("app_ajouterCom",array('id'=>$id2));
        }
        return $this->renderForm('front/updateCom.html.twig', array("form" => $form));
    }

    #[Route('/supprimerCom/{id}/{id2}', name: 'app_supprimerCom')]
    public function supprimerComment(CommentaireActRepository $repository,$id2, $id, ManagerRegistry $doctrine)
    {
        $comment = $repository->find($id);
        $form = $this->createForm(CommentaireActType::class, $comment);
        $em = $doctrine->getManager();
        $em->remove($comment);
        $em->flush();
        return $this->redirectToRoute("app_ajouterCom",array('id'=>$id2));

    }

    #[Route('/recherche', name: 'app_recherche')]
    public function recherche(ActualiteRepository $repository, Request $request)
    {
        $query = $request->query->get('q'); // Get the search query from the request

        if (!$query) {
            return $this->redirectToRoute('app_front'); // Redirect to the main page if no query is provided
        }

        $actualites = $repository->search($query); // Use a custom method in your repository to search for actualités based on the query

        return $this->render('front/recherche.html.twig', [
            'query' => $query,
            'actualites' => $actualites,
        ]);
    }

}
