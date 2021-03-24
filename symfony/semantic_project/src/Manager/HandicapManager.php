<?php

namespace App\Manager;

use App\Repository\HandicapRepository;

/**
 * Class HandicapManager
 *
 * @package App\Manager
 */
class HandicapManager
{
    /**
     * @var HandicapRepository $handicapRepository
     */
    protected $handicapRepository;

    /**
     * HandicapManager constructor.
     *
     * @param HandicapRepository $handicapRepository
     */
    public function __construct(HandicapRepository $handicapRepository)
    {
        $this->handicapRepository = $handicapRepository;
    }

    /**
     * @return mixed
     */
    public function countHandicap()
    {
        return $this->handicapRepository->countHandicap();
    }

    /**
     * @param $page
     *
     * @return mixed
     */
    public function getHandicap($page)
    {
        $offset = $page * 25;
        $results = $this->handicapRepository->getHandicap($offset);

        $tab = [];
        foreach ($results as $res) {
            $tmp = [];
            $tmp["nom_gare"] = $res["nom_gare"]["value"];
            $tmp["helped_disabled_nb"] = $res["helped_disabled_nb"]["value"];
            $tmp["simple_support"] = $res["simple_support"]["value"];
            array_push($tab, $tmp);
        }

        return $tab;
    }
}
