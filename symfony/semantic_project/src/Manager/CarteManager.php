<?php

namespace App\Manager;

use App\Repository\CarteRepository;

/**
 * Class CarteManager
 *
 * @package App\Manager
 */
class CarteManager
{
    /**
     * @var CarteRepository $carteRepository
     */
    protected $carteRepository;

    /**
     * CarteManager constructor.
     *
     * @param CarteRepository $carteRepository
     */
    public function __construct(CarteRepository $carteRepository)
    {
        $this->carteRepository = $carteRepository;
    }
    /**
     * @return mixed
     */
    public function getGrosTas(): array
    {
        $results = $this->carteRepository->getGrosTas();
        $tab = [];
        foreach ($results as $res) {
            $tmp = [];
            $tmp["nom_gare"] = $res["nom_gare"]["value"];
            $tmp["ville"] = $res["ville"]["value"];
            $tmp["cp"] = $res["cp"]["value"];
            $tmp["lat"] = $res["lat"]["value"];
            $tmp["lon"] = $res["lon"]["value"];
            if (array_key_exists("wifi", $res)) $tmp["wifi"] = $res["wifi"]["value"];
            if (array_key_exists("helped_disabled_nb", $res)) $tmp["helped_disabled_nb"] = $res["helped_disabled_nb"]["value"];
            array_push($tab, $tmp);
        }
        return $tab;
    }

    /**
     * @return array
     */
    public function getWifiGares(): array
    {
        $results = $this->carteRepository->getWifiGares();
        $tab = [];
        foreach ($results as $res) {
            $tmp = [];
            $tmp["nom_gare"] = $res["nom_gare"]["value"];
            $tmp["ville"] = $res["ville"]["value"];
            $tmp["cp"] = $res["cp"]["value"];
            $tmp["lat"] = $res["lat"]["value"];
            $tmp["lon"] = $res["lon"]["value"];
            array_push($tab, $tmp);
        }
        return $tab;
    }
}
