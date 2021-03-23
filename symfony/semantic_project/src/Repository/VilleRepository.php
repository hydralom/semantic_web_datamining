<?php

namespace App\Repository;

use Exception;
use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;

/**
 * Class VilleRepository
 *
 * @package App\Repository
 */
class VilleRepository
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
