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

    public function getHandicap()
    {
        return $this->handicapRepository->getHandicap();
    }

    public function getHandicapByCity(string $city)
    {
        return $this->handicapRepository->getHandicapByCity($city);
    }
}
