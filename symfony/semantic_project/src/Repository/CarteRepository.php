<?php

namespace App\Repository;

use Exception;
use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;

/**
 * Class CarteRepository
 *
 * @package App\Repository
 */
class CarteRepository
{
    private $url = "http://jena_fuseki:3030/gros_tas/query?query=";

    /**
     * @return mixed
     */
    public function getGrosTas()
    {
        $query_villes = "
           SELECT DISTINCT ?sujet ?nom_gare ?ville ?cp ?lon ?lat ?helped_disabled_nb ?wifi
           WHERE {
             ?subject <http://confinos.fr/train_stations#code_postal> ?cp .
             ?subject <http://confinos.fr/train_stations#commune_name> ?ville .
             ?subject <http://confinos.fr/train_stations#nom_gare> ?nom_gare .
             ?subject <http://confinos.fr/train_stations#longitude> ?lon .
             ?subject <http://confinos.fr/train_stations#latitude> ?lat .
             OPTIONAL {
                 ?subject <http://confinos.fr/disabled_person_helped#helped_disabled_nb> ?helped_disabled_nb .
                 ?subject <http://confinos.fr/wifi#wifi_actif> ?wifi .
             }
           }
        ";
        $fuseki_response = $this->askFuseki($this->url . urlencode($query_villes));
        $villes_raw = json_decode($fuseki_response, true);
        return $villes_raw["results"]["bindings"];
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
