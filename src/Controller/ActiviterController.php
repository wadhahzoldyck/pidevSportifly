<?php

namespace App\Controller;

use App\Entity\Activiter;
use App\Entity\User;
use App\Form\ActiviterType;

use App\Repository\ActiviterRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ActiviterController extends AbstractController
{
    #[Route('/activiter', name: 'app_activiter')]
    public function affiche_act(ActiviterRepository $repository,UserRepository $repository2): Response
    { $user=new User();
        $user=$repository2->find(1 );
        $activiter= $repository->findBy(['id_user' => $user]);
        return $this->render("activiter/liste.html.twig",array("tabActiviter"=>$activiter));
    }



    #[Route('/liste_activ', name: 'liste_activiter')]
    public function affiche2_act(ActiviterRepository $repository): Response
    {
        $activiter= $repository->findAll();
        return $this->render("activiter/liste_back.html.twig",array("tabActiviter"=>$activiter));
    }

    #[Route('/add_activiter', name: 'app_addactiviter')]
    public function addactiviter(Request $request,ManagerRegistry $doctrine,UserRepository $repository): Response
    {

        $user=new User();
        $user=$repository->find(1);
        $Activ=new Activiter();
        $form= $this->createForm(ActiviterType::class,$Activ);
        $Activ->setIdUser($user);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){


            $em =$doctrine->getManager() ;
            $em->persist($Activ);
            $em->flush();
            return $this->redirectToRoute("liste_activiter");
        }
        return $this->renderForm("activiter/addActivit.html.twig",
            array("form"=>$form));


    }
    #[Route('/add_activiter_front', name: 'app_addactiviter_front')]
    public function addactiviter2(Request $request,ManagerRegistry $doctrine,UserRepository $repository): Response
    {

        $user=new User();
        $user=$repository->find(1);
        $Activ=new Activiter();
        $form= $this->createForm(ActiviterType::class,$Activ);
        $Activ->setIdUser($user);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){


            $em =$doctrine->getManager() ;
            $em->persist($Activ);
            $em->flush();
            return $this->redirectToRoute("app_activiter");
        }
        return $this->renderForm("activiter/addfront.html.twig",
            array("form"=>$form));


    }





    #[Route('/updateactiviter/{id}',name:   'app_updateactiviter') ]
    Public function updateActiviter(ActiviterRepository $repository,$id,ManagerRegistry $doctrine,Request $request)
    {
        $activiter=$repository->find($id);
        $form=$this->createForm(ActiviterType::class,$activiter);
        $form->handleRequest($request);
        if($form->isSubmitted())
        {$em=$doctrine->getManager();
        $em->flush();
        return $this->redirectToRoute("liste_activiter");
        }
        return $this->renderForm("activiter/updateActivit.html.twig",
        array("form"=>$form));

    }


    #[Route('/updateactiviter_front/{id}',name:   'app_updateactiviter_front') ]
    Public function updateActiviter2(ActiviterRepository $repository,$id,ManagerRegistry $doctrine,Request $request)
    {
        $activiter=$repository->find($id);
        $form=$this->createForm(ActiviterType::class,$activiter);
        $form->handleRequest($request);
        if($form->isSubmitted())
        {$em=$doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute("app_activiter");
        }
        return $this->renderForm("activiter/updateActfront.html.twig",
            array("form"=>$form));

    }




#[Route('/removeactiviter/{id}',name:   'app_removeactiviter') ]
Public function removeActiviter(ActiviterRepository $repository,$id,ManagerRegistry $doctrine)
{
    $activiter=$repository->find($id);
    $em=$doctrine->getManager();
    $em->remove($activiter);
    $em->flush();
    return $this->redirectToRoute("app_activiter");
}




    #[Route('/removeactiviter_back/{id}',name:   'app_removeactiviter_back') ]
    Public function removeActiviter2(ActiviterRepository $repository,$id,ManagerRegistry $doctrine)
    {
        $activiter=$repository->find($id);
        $em=$doctrine->getManager();
        $em->remove($activiter);
        $em->flush();
        return $this->redirectToRoute("liste_activiter");
    }


}
