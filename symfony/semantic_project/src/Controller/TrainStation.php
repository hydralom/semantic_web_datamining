<?php

namespace App\Controller;

use App\Manager\TrainStationManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class TrainStation
 *
 * @package App\Controller
 */
class TrainStation extends AbstractController
{
    /**
     * @var TrainStationManager $trainStationManager
     */
    protected $trainStationManager;

    /**
     * TrainStation constructor.
     *
     * @param TrainStationManager $trainStationManager
     */
    public function __construct(TrainStationManager $trainStationManager)
    {
        $this->trainStationManager = $trainStationManager;
    }

    /**
     * @Route("/trainstations/{city}", name="trainstations", defaults={"city"="Z"}))
     *
     * @param string $city
     *
     * @return Response
     */
    public function TrainStationsCity(string $city): Response
    {
        $villes = $this->trainStationManager->getVilles();
        $trainstations = $city == "Z" ?
            $this->trainStationManager->getTrainStations() :
            $this->trainStationManager->getTrainStationsByCity($city);

        return $this->render('trainstations/trainstations.html.twig', [
            'villes' => $villes,
            'trainstations' => $trainstations,
        ]);
    }
}
