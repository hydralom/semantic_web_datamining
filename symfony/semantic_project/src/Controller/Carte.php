<?php

namespace App\Controller;

use App\Manager\CarteManager;
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
     * @var CarteManager $carteManager
     */
    private $carteManager;

    /**
     * Carte constructor.
     *
     * @param CarteManager $carteManager
     */
    public function __construct(CarteManager $carteManager)
    {
        $this->carteManager = $carteManager;
    }

    /**
     * @Route("/carte", name="carte")
     *
     * @return Response
     */
    public function AllInOne(): Response
    {
        $grosTas = $this->carteManager->getGrosTas();

        return $this->render('carte/all_in_one.html.twig', [
            'grosTas' => $grosTas,
        ]);
    }
}
