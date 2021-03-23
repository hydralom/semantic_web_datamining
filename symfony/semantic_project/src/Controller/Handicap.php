<?php

namespace App\Controller;

use App\Manager\VilleManager;
use App\Manager\HandicapManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class Handicap
 *
 * @package App\Controller
 */
class Handicap extends AbstractController
{
    /**
     * @var HandicapManager $handicapManager
     */
    protected $handicapManager;

    /**
     * @var VilleManager $villeManager
     */
    protected $villeManager;

    /**
     * Handicap constructor.
     *
     * @param HandicapManager $handicapManager
     * @param VilleManager $villeManager
     */
    public function __construct(
        HandicapManager $handicapManager,
        VilleManager $villeManager
    )
    {
        $this->handicapManager = $handicapManager;
        $this->villeManager = $villeManager;
    }

    /**
     * @Route("/handicap/{city}", name="handicap", defaults={"city"="Z"}))
     *
     * @param string $city
     *
     * @return Response
     */
    public function TrainStationsCity(string $city): Response
    {
        $villes = $this->villeManager->getVilles();
        $handicap = $city == "Z" ?
            $this->handicapManager->getHandicap() :
            $this->handicapManager->getHandicapByCity($city);

        return $this->render('trainstations/trainstations.html.twig', [
            'villes' => $villes,
            'handicap' => $handicap,
        ]);
    }
}
