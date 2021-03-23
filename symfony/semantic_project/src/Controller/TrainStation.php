<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class TrainStation
 *
 * @package App\Controller
 */
class TrainStation extends AbstractController
{
    /**
     * @var string
     */
    private $url = "http://jena_fuseki:3030/trainstation/query?query=";

    /**
     * @Route("/trainstations/{city}", name="trainstations", defaults={"city"="Z"}))
     *
     * @param string $city
     *
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function TrainStationsCity(string $city): Response
    {
        $url = $this->url;

        $query_villes = "
           SELECT DISTINCT ?ville
           WHERE {
               ?subject <http://confinos.fr/train_stations#commune_name> ?ville .
           }
           ORDER BY ASC(?ville)
        ";
        $fuseki_response = $this->askFuseki($url . urlencode($query_villes));
        $villes_raw = json_decode($fuseki_response, true);
        $villes = $villes_raw["results"]["bindings"];

        if ($city == "Z") {
            $queryTs = "
           SELECT ?nom ?lat ?lon
           WHERE {
               ?subject <http://confinos.fr/train_stations#nom_gare_pretty> ?nom .
               ?subject <http://confinos.fr/train_stations#latitude> ?lat .
               ?subject <http://confinos.fr/train_stations#longitude> ?lon .
           }
           ORDER BY ASC(?nom)
        ";
        } else {
            $queryTs = "
           SELECT ?nom ?lat ?lon
           WHERE {
               ?subject <http://confinos.fr/train_stations#commune_name> \"" . $city . "\" .
               ?subject <http://confinos.fr/train_stations#nom_gare_pretty> ?nom .
               ?subject <http://confinos.fr/train_stations#latitude> ?lat .
               ?subject <http://confinos.fr/train_stations#longitude> ?lon .
           }
           ORDER BY ASC(?nom)
        ";
        }
        $fuseki_response = $this->askFuseki($url . urlencode($queryTs));
        $content = json_decode($fuseki_response, true);
        $trainstations = $content["results"]["bindings"];

        return $this->render('trainstations/trainstations.html.twig', [
            'villes' => $villes,
            'trainstations' => $trainstations,
        ]);
    }

    /**
     * @param string $url
     *
     * @throws TransportExceptionInterface
     */
    private function askFuseki(string $url): string
    {
        $client = new CurlHttpClient();
        $response = $client->request(
            'POST',
            $url, [
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]
        );

        return $response->getContent();
    }
}
