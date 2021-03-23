<?php

namespace App\Repository;

use Exception;
use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;

/**
 * Class HandicapRepository
 *
 * @package App\Repository
 */
class HandicapRepository
{
    private $url = "http://jena_fuseki:3030/handicap/query?query=";

    /**
     * @return mixed
     */
    public function getHandicap()
    {
        $query = "
           SELECT ?nom_gare ?ramp ?wheelchairs ?wheelchairs_on_ramps ?helped_disabled_nb ?simple_support
           WHERE {
             ?subject <http://confinos.fr/disabled_person_helped#nom_gare> ?nom_gare .
             ?subject <http://confinos.fr/disabled_person_helped#ramps> ?ramps .
             ?subject <http://confinos.fr/disabled_person_helped#wheelchairs> ?wheelchairs .
             ?subject <http://confinos.fr/disabled_person_helped#wheelchairs_on_ramps> ?wheelchairs_on_ramps .
             ?subject <http://confinos.fr/disabled_person_helped#helped_disabled_nb> ?helped_disabled_nb .
             ?subject <http://confinos.fr/disabled_person_helped#simple_support> ?simple_support .
           }
           ORDER BY ASC(?nom_gare)
        ";

        $fuseki_response = $this->askFuseki($this->url . urlencode($query));
        $content = json_decode($fuseki_response, true);
        return $content["results"]["bindings"];
    }

    public function getHandicapByCity(string $city)
    {
        $query = "
           SELECT ?nom ?lat ?lon
           WHERE {
               ?subject <http://confinos.fr/train_stations#commune_name> \"" . $city . "\" .
               ?subject <http://confinos.fr/train_stations#nom_gare_pretty> ?nom .
               ?subject <http://confinos.fr/train_stations#latitude> ?lat .
               ?subject <http://confinos.fr/train_stations#longitude> ?lon .
           }
           ORDER BY ASC(?nom)
        ";

        $fuseki_response = $this->askFuseki($this->url . urlencode($query));
        $content = json_decode($fuseki_response, true);
        return $content["results"]["bindings"];
    }

    /**
     * @param string $url
     *
     * @return string
     */
    private function askFuseki(string $url): string
    {
        $client = new CurlHttpClient();
        try {
            $response = $client->request(
                'POST',
                $url, [
                    'headers' => [
                        'Accept' => 'application/json',
                    ],
                ]
            );
            $result = $response->getContent();
        } catch (Exception | TransportExceptionInterface | ClientExceptionInterface | RedirectionExceptionInterface | ServerExceptionInterface $e) {
            $result = "failed";
        }

        return $result;
    }

}
