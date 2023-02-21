<?php

namespace App\Controller;

use ApiPlatform\Api\UrlGeneratorInterface;
use App\Form\ForgotPasswordType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');

    }

    #[Route(path: '/forgot', name: 'forgot')]
    public function forgotpassword(Request $request, UserRepository $userRepository, \Swift_Mailer $mailer, TokenGeneratorInterface $tokenGenerator, ManagerRegistry $doctrine)
    {
        $form = $this->createForm(ForgotPasswordType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $donnees = $form->getData();
            $user = $userRepository->findOneBy(['email' => $donnees]);

            if (!$user) {
                $this->addFlash('danger', 'cette adresse non existante');
                return $this->redirectToRoute("app_login");
            }

            $token = $tokenGenerator->generateToken();
            try {
                $user->setResetToken($token);
                $em = $doctrine->getManager();
                $em->persist($user);
                $em->flush();


            } catch (\Exception $exception) {
                $this->addFlash('warning', 'une erreur est survenue:' .$exception->getMessage());
                return $this->redirectToRoute("app_login");
            }
            $url = $this->generateUrl('app_reset_password', array('token' => $token), UrlGeneratorInterface::ABS_URL);
            //Bundle mail
            $message = (new \Swift_Message('mot de passe oublié'))
                ->setFrom('amirakhalfy12@gmail.com')
                ->setTo($user->getEmail())
                ->setBody("<p>Bonjour </p>votre demande de réinitialisation de mot de passe a été effectuée. Veuillez cliquer sur le lien suivant :" . $url, "text/html");

            //send mail
            $mailer->send($message);
            $this->addFlash('message', 'email de réinitialisation du mot de passe est envoyé :' .$exception->getMessage());


        }

        return $this->render("security/forgotpassword.html.twig",['form'=>$form->createView()]);
    }
    #[Route(path: '/resetpassword', name: 'app_reset_password')]
    public function resetpassword():RedirectResponse
    {
      return $this->redirectToRoute("app_login");

    }
}


