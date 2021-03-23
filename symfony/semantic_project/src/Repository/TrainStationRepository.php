<?php

namespace App\Repository;

use Exception;
use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;

/**
 * Class TrainStationRepository
 *
 * @package App\Repository
 */
class TrainStationRepository
{
    private $url = "http://jena_fuseki:3030/trainstation/query?query=";

    /**
     * @return mixed
     */
    public function getVilles()
    {
        $query_villes = "
           SELECT DISTINCT ?ville
           WHERE {
               ?subject <http://confinos.fr/train_stations#commune_name> ?ville .
           }
           ORDER BY ASC(?ville)
        ";
        $fuseki_response = $this->askFuseki($this->url . urlencode($query_villes));
        $villes_raw = json_decode($fuseki_response, true);
        return $villes_raw["results"]["bindings"];
    }

    /**
     * @param $city
     *
     * @return mixed
     */
    public function getTrainStationsByCity($city)
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
     * @return mixed
     */
    public function getTrainStations()
    {
        $query = "
           SELECT ?nom ?lat ?lon
           WHERE {
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
