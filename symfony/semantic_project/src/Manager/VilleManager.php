<?php

namespace App\Manager;

use App\Repository\VilleRepository;

/**
 * Class VilleManager
 *
 * @package App\Manager
 */
class VilleManager
{
    /**
     * @var VilleRepository $villeRepository
     */
    protected $villeRepository;

    /**
     * VilleManager constructor.
     *
     * @param VilleRepository $villeRepository
     */
    public function __construct(VilleRepository $villeRepository)
    {
        $this->villeRepository = $villeRepository;
    }
    /**
     * @return mixed
     */
    public function getVilles()
    {
        return $this->villeRepository->getVilles();
    }
}
