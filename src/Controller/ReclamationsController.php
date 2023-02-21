<?php

namespace App\Controller;
use App\Entity\User;
use App\Entity\Reclamation;
use App\Entity\Reclamations;
use App\Form\ReclamationsType;
use App\Form\ReclamationType;
use App\Repository\ReclamationsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping\Id;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reclamations')]
class ReclamationsController extends AbstractController
{
    #[Route('/', name: 'app_reclamations_index', methods: ['GET'])]
    public function index(ReclamationsRepository $reclamationsRepository): Response
    {
        return $this->render('reclamations/index.html.twig', [
            'reclamation' => $reclamationsRepository->findAll(),
        ]);
    }

    #[Route('/addreclamationfront/{name}', name: 'app_reclamations_new')]
    public function new(Request $request,ManagerRegistry $doctrine,UserRepository $repository,$name)
    {$user=new User();
        $reclamation = new Reclamations();
        $form = $this->createForm(ReclamationsType::class, $reclamation);
        $form->handleRequest($request);

        $user=$repository->findOneBy(['email'=>$name]);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $reclamation->setUser($user);
            $em->persist($reclamation);
            $em->flush();
            return $this->redirectToRoute('app_home');
        }

        return $this->renderForm("reclamations/addreclamationfront.html.twig", array("reclamation" => $form));
    }

    #[Route('/{id}', name: 'app_reclamations_show', methods: ['GET'])]
    public function show(Reclamations $reclamation): Response
    {
        return $this->render('reclamations/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reclamations_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reclamations $reclamation, ReclamationsRepository $reclamationsRepository): Response
    {
        $form = $this->createForm(ReclamationsType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamationsRepository->save($reclamation, true);

            return $this->redirectToRoute('app_reclamations_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm("reclamations/addreclamationfront.html.twig", array("reclamation" => $form));

    }

    #[Route('/{id}', name: 'app_reclamations_delete', methods: ['POST'])]
    public function delete(Request $request, Reclamations $reclamation, ReclamationsRepository $reclamationsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamation->getId(), $request->request->get('_token'))) {
            $reclamationsRepository->remove($reclamation, true);
        }

        return $this->redirectToRoute('app_reclamations_index', [], Response::HTTP_SEE_OTHER);
    }



}
