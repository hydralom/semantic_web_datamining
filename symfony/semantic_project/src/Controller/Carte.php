<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class Carte
 *
 * @package App\Controller
 */
class Carte extends AbstractController
{

    /**
     * @Route("/trainstations/{api}/{city}", name="trainstations", defaults={"city"="Z","api"="Z"}))
     *
     * @param string $city
     *
     * @return Response
     */
    public function TrainStationsCity(string $city): Response
    {
        $queryTs = "
           SELECT ?nom ?lat ?lon
           WHERE {
               ?subject <http://confinos.fr/train_stations#nom_gare_pretty> ?nom .
               ?subject <http://confinos.fr/train_stations#latitude> ?lat .
               ?subject <http://confinos.fr/train_stations#longitude> ?lon .
           }
           ORDER BY ASC(?nom)
        ";

        return $this->render('carte/all_in_one.html.twig', [
        ]);
    }
}
