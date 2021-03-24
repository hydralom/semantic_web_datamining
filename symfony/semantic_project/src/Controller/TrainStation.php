<?php

namespace App\Controller;

use App\Manager\VilleManager;
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
     * @var VilleManager $villeManager
     */
    protected $villeManager;

    /**
     * TrainStation constructor.
     *
     * @param TrainStationManager $trainStationManager
     * @param VilleManager $villeManager
     */
    public function __construct(
        TrainStationManager $trainStationManager,
        VilleManager $villeManager
    )
    {
        $this->trainStationManager = $trainStationManager;
        $this->villeManager = $villeManager;
    }

    /**
     * @Route("/", name="home")
     *
     * @return Response
     */
    public function RedirectToTrainstations(): Response
    {
        return $this->redirect("trainstations");
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
        $villes = $this->villeManager->getVilles();
        $trainstations = $city == "Z" ?
            $this->trainStationManager->getTrainStations() :
            $this->trainStationManager->getTrainStationsByCity($city);

        return $this->render('trainstations/trainstations.html.twig', [
            'villes' => $villes,
            'trainstations' => $trainstations,
        ]);
    }
}
