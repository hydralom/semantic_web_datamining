<?php

namespace App\Manager;

use App\Repository\TrainStationRepository;

/**
 * Class TrainStationManager
 *
 * @package App\Manager
 */
class TrainStationManager
{
    /**
     * @var TrainStationRepository $trainStationRepository
     */
    protected $trainStationRepository;

    /**
     * TrainStationManager constructor.
     *
     * @param TrainStationRepository $trainStationRepository
     */
    public function __construct(TrainStationRepository $trainStationRepository)
    {
        $this->trainStationRepository = $trainStationRepository;
    }

    /**
     * @param $city
     *
     * @return mixed
     */
    public function getTrainStationsByCity($city)
    {
        $results = $this->trainStationRepository->getTrainStationsByCity($city);

        $tab = [];
        foreach ($results as $res) {
            $tmp = [];
            $tmp["nom"] = $res["nom"]["value"];
            $tmp["lat"] = $res["lat"]["value"];
            $tmp["lon"] = $res["lon"]["value"];
            array_push($tab, $tmp);
        }
        return $tab;
    }

    /**
     * @return mixed
     */
    public function getTrainStations()
    {
        $results = $this->trainStationRepository->getTrainStations();

        $tab = [];
        foreach ($results as $res) {
            $tmp = [];
            $tmp["nom"] = $res["nom"]["value"];
            $tmp["lat"] = $res["lat"]["value"];
            $tmp["lon"] = $res["lon"]["value"];
            array_push($tab, $tmp);
        }
        return $tab;
    }
}
