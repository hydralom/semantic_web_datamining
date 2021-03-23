<?php

namespace App\Controller;

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
     * Handicap constructor.
     *
     * @param HandicapManager $handicapManager
     */
    public function __construct(HandicapManager $handicapManager)
    {
        $this->handicapManager = $handicapManager;
    }

    /**
     * @Route("/handicap/{page}", name="handicap", defaults={"page"="1"}))
     *
     * @param string $page
     *
     * @return Response
     */
    public function HandicapPaginated(string $page): Response
    {
        $handicap = $this->handicapManager->getHandicap($page - 1);

        $nbHandicap = $this->handicapManager->countHandicap();
        $nbPages = ceil($nbHandicap[0]["count"]["value"] / 25.0) + 2;

        return $this->render('handicap/handicap.html.twig', [
            'handicap' => $handicap,
            'nbPages' => $nbPages,
            'page' => $page,
        ]);
    }
}
