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
     * @Route("/carte", name="carte_all_in_one")
     *
     * @return Response
     */
    public function AllInOne(): Response
    {
        return $this->render('carte/all_in_one.html.twig', [
        ]);
    }
}
