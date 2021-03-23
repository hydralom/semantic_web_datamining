<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TrainStation extends AbstractController
{
    /**
     * @Route("/trainstation")
     */
    public function number(): Response
    {
        $number = random_int(0, 100);

        return $this->render('pages/trainstation.html.twig', [
            'number' => $number,
        ]);
    }
}
