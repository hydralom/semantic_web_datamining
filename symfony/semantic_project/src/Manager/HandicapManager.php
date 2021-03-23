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
        return $this->handicapRepository->getHandicap($offset);
    }
}
