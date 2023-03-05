<?php

namespace App\Controller;

use App\Entity\CategorieActivite;
use App\Entity\Offre;
use App\Entity\User;
use App\Form\OffreType;
use App\Repository\CategorieActiviteRepository;
use App\Repository\OffreRepository;

use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\String\Slugger\SluggerInterface;


class OffreController extends AbstractController
{
    //BACKOFFICE

    #[Route('admin', name: 'display_admin')]
    public function ndexadmin(): Response
    {

        return $this->render('admin/index.html.twig');
    }


    #[Route('admin/offre/listOffre', name: 'app_listoffre')]
    public function affOffre(OffreRepository $repository , UserRepository $repository1): Response
    {

        $offre =$repository->findAll();

        return $this->render('offre/index.html.twig', array( 'listOffre' => $offre,));
    }

    //USER display offres
    #[Route('/offre/AllOffres', name: 'app_Alloffre')]
    public function allOffre(OffreRepository $repository , UserRepository $repository1): Response
    {
         //$user = new User();
        //$user->getuser
        //$user = $repository1->find(2);

        $offre =$repository->findAvailableOffersByUserId(2);

        return $this->render('offre/userspace.html.twig', array( 'listOffre' => $offre,));
    }




    #[Route('offre/{id}/show', name: 'app_offre_show')]
    public function show(OffreRepository $repository,$id)
    {
        $offre = $repository->find($id);

        return $this->render('offre/editfront.html.twig', [
            'offre' => $offre,
        ]);
    }




    //tchouf is connnected wala la #xxx !!importation!! import user entity
    #[Route('offre/Addoffre', name: 'app_addOffre')]
    public function addOffre(Request $request , ManagerRegistry $doctrine , UserRepository $repository,SluggerInterface $slugger)
    {

        $user = new User();
        //$user->getuser
        $user = $repository->find(2);
        //findby$user

        $offre = new Offre();
        $form = $this->createForm(OffreType::class, $offre);
        $offre->setIdUser($user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() ){
            $affiche = $form->get('affiche')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($affiche) {
                $originalFilename = pathinfo($affiche->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$affiche->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $affiche->move(
                        $this->getParameter('offre_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $offre->setAffiche($newFilename);
            }
            $em = $doctrine->getManager();
            $em->persist($offre);
            $em->flush();
            return $this->redirectToRoute('app_listoffre');

        }

        return $this->renderForm('offre/add.html.twig', array("form"=> $form));

    }




//Add Offre in front
    #[Route('offre/Addoffrefront', name: 'app_addOffrefront')]
    public function addOffre1(Request $request , ManagerRegistry $doctrine , UserRepository $repository,SluggerInterface $slugger):Response
    {

        $user = new User();
        //$user->getuser
        $user = $repository->find(2);
        //findby$user

        $offre = new Offre();
        $form = $this->createForm(OffreType::class, $offre);
        $offre->setIdUser($user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() ){
            $affiche = $form->get('affiche')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($affiche) {
                $originalFilename = pathinfo($affiche->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$affiche->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $affiche->move(
                        $this->getParameter('offre_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $offre->setAffiche($newFilename);
            }
            $em = $doctrine->getManager();
            $em->persist($offre);
            $em->flush();
            return $this->redirectToRoute('app_listoffrefront');

        }

        return $this->renderForm('offre/addfront.html.twig', array("form"=> $form));

    }




    #[Route('admin/offre/{id}/edit', name: 'app_editOffre')]
    public function editOffre(OffreRepository $repository,$id,ManagerRegistry $doctrine,Request $request)
    {
        $offre = $repository->find($id);
        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() ){
            $em = $doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute('app_listoffre');

        }
        return $this->renderForm('offre/edit.html.twig', array("form"=> $form));


    }
    #[Route('/removeOffre/{id}', name: 'app_removeOffre')]

    public function deleteOffre(ManagerRegistry $doctrine,$id,OffreRepository  $repository)
    {
        $offre= $repository->find($id);
        $em= $doctrine->getManager();
        $em->remove($offre);
        $em->flush();
        return $this->redirectToRoute("app_listoffrefront");

    }

    #[Route('/removeOffreBack/{id}', name: 'app_removeOffreBack')]

    public function deleteOffreBack(ManagerRegistry $doctrine,$id,OffreRepository  $repository)
    {
        $offre= $repository->find($id);
        $em= $doctrine->getManager();
        $em->remove($offre);
        $em->flush();
        return $this->redirectToRoute("app_listoffre");

    }

    //FRONTOFFICE



    #[Route('offre/editfront/{id}', name: 'offre_modify')]
    public function editOffre1(OffreRepository $repository,$id,ManagerRegistry $doctrine,Request $request)
    {
        $offre = $repository->find($id);
        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() ){
            $em = $doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute('app_listoffrefront');

        }
        return $this->render('offre/editfront.html.twig', [
            'offre'=>$offre,
            'form' => $form->createView(),
        ]);


    }



    #[Route('/offre/listOffre', name: 'app_listoffrefront')]
    public function afficher_offre(OffreRepository $repository , UserRepository $repository1 , CategorieActiviteRepository $catRepo,Request $request): Response
    {
        //on récupére  les filtres
        $filters =$request->get("categories");


        $user= new User();
        $user = $repository1->find(2);
        //récupere les offres de la page en fonction des filtres
        $offre =$repository->getOffresbyCat($filters,2);

        //

        $form = $this->createForm(OffreType::class);
        //Verifier si il ya une requette ajax

        if($request->get('ajax')){
            return new JsonResponse([
                'content' => $this->renderView('offre/_feed.html.twig', [
                    'listOffre' => $offre,
                    'form' => $form->createView(),
                ])
            ]);
        }

        $categories = $catRepo->findAll();
        return $this->render('offre/index1.html.twig', [
            'listOffre' => $offre,
            'categories' => $categories,
            'form' => $form->createView(),
        ]);
    }


    //JSON FUNCTIONS


    //USERINTERFACE DISPLAY OFFRES
    #[Route('/offre/AllOffresJson', name: 'app_AlloffreJson')]
    public function allOffreJSON(OffreRepository $repository , UserRepository $repository1 , NormalizerInterface $normalizer): Response
    {
        //$user = new User();
        //$user->getuser
        //$user = $repository1->find(2);

        $offre =$repository->findAvailableOffersByUserId(2);
//        $serializer = new Serializer([new ObjectNormalizer()]);
//        $formatted = $serializer->normalize($offre , 'json' , ['groups' =>"Offre"]);
        $offresNormalises = $normalizer->normalize($offre,'json', ['groups' =>"Offre"]);
        $json = json_encode($offresNormalises);
        return  new Response($json);
    }

    //COACHINTERFACEDISPLAYOFFERS
    #[Route('/offre/listOffreJson', name: 'app_listoffrefrontJson')]
    public function afficher_offreJson(NormalizerInterface $normalizer,OffreRepository $repository , UserRepository $repository1 , CategorieActiviteRepository $catRepo,Request $request): Response
    {
        //on récupére  les filtres


        $user= new User();
        $user = $repository1->find(2);
        //récupere les offres de la page en fonction des filtres
        $offre =$repository->findBy(['id_user' =>$user]);

        $offresNormalises = $normalizer->normalize($offre,'json', ['groups' =>"Offre"]);
        $json = json_encode($offresNormalises);
        return  new Response($json);


    }

    //ADD OFFREJSON

    #[Route('offre/AddoffrefrontJson/new', name: 'app_addOffrefrontJson')]
    public function addOffreJson(CategorieActiviteRepository $repos,NormalizerInterface $normalizer,Request $request , ManagerRegistry $doctrine , UserRepository $repository,SluggerInterface $slugger):Response
    {

        $user = new User();
        //$user->getuser
        $user = $repository->find($request->get('id_user'));
        $category = new CategorieActivite();
        $category = $repos->find($request->get('id_category'));

        $dateString = $request->get('date');
        $date = new \DateTime($dateString);

        //findby$user

        $offre = new Offre();
        $offre->setIdUser($user);
        $offre->setDate($date);
        $offre->setPrix($request->get('prix'));
        $offre->setDescription($request->get('description'));
        $offre->setAffiche($request->get('affiche'));
        $offre->setIdCategory($category);






//        $form = $this->createForm(OffreType::class, $offre);
//        $form->handleRequest($request);
//        if($form->isSubmitted() && $form->isValid() ){
//            $affiche = $form->get('affiche')->getData();
//
//            // this condition is needed because the 'brochure' field is not required
//            // so the PDF file must be processed only when a file is uploaded
//            if ($affiche) {
//                $originalFilename = pathinfo($affiche->getClientOriginalName(), PATHINFO_FILENAME);
//                // this is needed to safely include the file name as part of the URL
//                $safeFilename = $slugger->slug($originalFilename);
//                $newFilename = $safeFilename.'-'.uniqid().'.'.$affiche->guessExtension();
//
//                // Move the file to the directory where brochures are stored
//                try {
//                    $affiche->move(
//                        $this->getParameter('offre_directory'),
//                        $newFilename
//                    );
//                } catch (FileException $e) {
//                    // ... handle exception if something happens during file upload
//                }
//
//                // updates the 'brochureFilename' property to store the PDF file name
//                // instead of its contents
//                $offre->setAffiche($newFilename);
//            }
//
//
//        }
        $em = $doctrine->getManager();
        $em->persist($offre);
        $em->flush();

        $offresNormalises = $normalizer->normalize($offre,'json', ['groups' =>"Offre"]);
        $json = json_encode($offresNormalises);
        return  new Response($json);

    }
    //EDITOFFRE JSON

    #[Route('offre/EditoffrefrontJson/{id}', name: 'app_editOffrefrontJson')]
    public function EditOffreJson($id,OffreRepository $offrerep,CategorieActiviteRepository $repos,NormalizerInterface $normalizer,Request $request , ManagerRegistry $doctrine ,SluggerInterface $slugger):Response
    {

        $category = new CategorieActivite();
        $category = $repos->find($request->get('id_category'));

        $dateString = $request->get('date');
        $date = new \DateTime($dateString);


        $offre=$offrerep->find($id);
        $offre->setDate($date);
        $offre->setPrix($request->get('prix'));
        $offre->setDescription($request->get('description'));
        $offre->setAffiche($request->get('affiche'));
        $offre->setIdCategory($category);






//        $form = $this->createForm(OffreType::class, $offre);
//        $form->handleRequest($request);
//        if($form->isSubmitted() && $form->isValid() ){
//            $affiche = $form->get('affiche')->getData();
//
//            // this condition is needed because the 'brochure' field is not required
//            // so the PDF file must be processed only when a file is uploaded
//            if ($affiche) {
//                $originalFilename = pathinfo($affiche->getClientOriginalName(), PATHINFO_FILENAME);
//                // this is needed to safely include the file name as part of the URL
//                $safeFilename = $slugger->slug($originalFilename);
//                $newFilename = $safeFilename.'-'.uniqid().'.'.$affiche->guessExtension();
//
//                // Move the file to the directory where brochures are stored
//                try {
//                    $affiche->move(
//                        $this->getParameter('offre_directory'),
//                        $newFilename
//                    );
//                } catch (FileException $e) {
//                    // ... handle exception if something happens during file upload
//                }
//
//                // updates the 'brochureFilename' property to store the PDF file name
//                // instead of its contents
//                $offre->setAffiche($newFilename);
//            }
//
//
//        }
        $em = $doctrine->getManager();
        $em->persist($offre);
        $em->flush();

        $offresNormalises = $normalizer->normalize($offre,'json', ['groups' =>"Offre"]);
        $json = json_encode($offresNormalises);
        return  new Response($json);

    }

    //DELETE OFFRE
    #[Route('offre/DeleteJson/{id}', name: 'app_deleteJson')]
    public function DeleteOffreJson($id,OffreRepository $offrerep,CategorieActiviteRepository $repos,NormalizerInterface $normalizer,Request $request , ManagerRegistry $doctrine ,SluggerInterface $slugger):Response
    {




        $offre=$offrerep->find($id);







//        $form = $this->createForm(OffreType::class, $offre);
//        $form->handleRequest($request);
//        if($form->isSubmitted() && $form->isValid() ){
//            $affiche = $form->get('affiche')->getData();
//
//            // this condition is needed because the 'brochure' field is not required
//            // so the PDF file must be processed only when a file is uploaded
//            if ($affiche) {
//                $originalFilename = pathinfo($affiche->getClientOriginalName(), PATHINFO_FILENAME);
//                // this is needed to safely include the file name as part of the URL
//                $safeFilename = $slugger->slug($originalFilename);
//                $newFilename = $safeFilename.'-'.uniqid().'.'.$affiche->guessExtension();
//
//                // Move the file to the directory where brochures are stored
//                try {
//                    $affiche->move(
//                        $this->getParameter('offre_directory'),
//                        $newFilename
//                    );
//                } catch (FileException $e) {
//                    // ... handle exception if something happens during file upload
//                }
//
//                // updates the 'brochureFilename' property to store the PDF file name
//                // instead of its contents
//                $offre->setAffiche($newFilename);
//            }
//
//
//        }
        $em = $doctrine->getManager();
        $em->remove($offre);
        $em->flush();

        $offresNormalises = $normalizer->normalize($offre,'json', ['groups' =>"Offre"]);
        $json = json_encode($offresNormalises);
        return  new Response("Offre deleted succefully".$json);

    }

}
