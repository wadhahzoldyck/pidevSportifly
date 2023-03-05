<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserController extends AbstractController
{ private $userPasswordEncoder;
    public function __construct( UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }
    #[Route('/admin', name: 'app_user_index', methods: ['GET'])]    
    public function index(UserRepository $userRepository): Response 

    {
      /*  $user=$this->getUser();
        $role=$user->getRoles();
        if (in_array("ROLE_COACH", $role))
            return $this->redirectToRoute('app_dashAss');
        if (in_array("ROLE_USER", $role))
            return $this->redirectToRoute('app_dashpat');
        if (in_array("ROLE_MEDECIN", $role))
            return $this->redirectToRoute('app_dash');
        if (in_array("ROLE_ADMIN", $role))
            return $this->redirectToRoute('Dashboard');
      */
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/admin/Listuser', name: 'app_Listuser')]
    public function Listuser(UserRepository $repository){
        $user=$repository->findAll();
        return $this->render("user/index.html.twig",array("users"=>$user));

    }
    #[Route('/adduser', name: 'app_add_user', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success','Ajout avec Success');
            if ($user->getPassword()) {
                $user->setPassword(
                    $this->userPasswordEncoder->encodePassword($user, $user->getPassword())
                );
                $user->eraseCredentials();
            }
            $roles[]='';
            $user->setRoles($roles);
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/adduser.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
    #[Route('/admin/{id}/edituser', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edituser(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_Listuser', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edituser.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{email}/edituserfront', name: 'app_edit_profile', methods: ['GET', 'POST'])]
    public function edituserfront(Request $request, UserRepository $userRepository,$email,\Doctrine\Persistence\ManagerRegistry $doctrine,UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = new User();
        $user = $userRepository->findOneBy(['email' => $email]);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($user->getPassword()) {
                $user->setPassword(
                    $this->userPasswordEncoder->encodePassword($user, $user->getPassword())
                );
                $user->eraseCredentials();
            }
                $em = $doctrine->getManager();
                $em->flush();

                return $this->redirectToRoute('app_logout', [], Response::HTTP_SEE_OTHER);
            }

            return $this->renderForm('user/editprofil.html.twig', [
                'user' => $user,
                'form' => $form,
            ]);
        }



    #[Route('/admin/deleteuser/{id}', name: 'app_deleteuser')]
    public function delete(UserRepository $repository,$id,\Doctrine\Persistence\ManagerRegistry $doctrine){
        $user=$repository->find($id);
        $em=$doctrine->getManager();
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute("app_user_index");


    }


    #[Route('/Adm', name: 'app_adm')]
    public function affichage( ):Response{
        return $this->render("user/index.html.twig");
    }

}
