<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ActiviterRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalendarController extends AbstractController
{
    #[Route('/calendar', name: 'app_calendar')]
    public function index(ActiviterRepository $repository,UserRepository $rep): Response
    {
        $user=new User();
        $user=$rep->find(1 );
        $activiters= $repository->findBy(['id_user' => $user]);
        $emploit=[];
        foreach ($activiters as $activ){
            $emploit[]=[
                'id'=>$activ->getId(),
                'title'=> $activ->getTitre(),
                'start'=> $activ->getDateDebut()->format('Y-m-d H:i:s'),
                'end'=> $activ->getDateFin()->format('Y-m-d H:i:s'),
                'backgroundColor'=>$this->getRandomColor()
            ];
        }
        $data=json_encode($emploit);

        return $this->render('calendar/Calendar.html.twig',compact('data'));
    }
    private function getRandomColor()
    {
        // Generate random values for the red, green, and blue components
        $r = mt_rand(100, 255);
        $g = mt_rand(100, 255);
        $b = mt_rand(100, 255);

        // Combine the red, green, and blue components into a hexadecimal color string
        $color = "#" . dechex($r) . dechex($g) . dechex($b);

        return $color;
    }
}
