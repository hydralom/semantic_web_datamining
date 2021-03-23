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
        return $this->trainStationRepository->getTrainStationsByCity($city);
    }

    /**
     * @return mixed
     */
    public function getTrainStations()
    {
        return $this->trainStationRepository->getTrainStations();
    }

    /**
     * @return mixed
     */
    public function getVilles()
    {
        return $this->trainStationRepository->getVilles();
    }
}
