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
}
