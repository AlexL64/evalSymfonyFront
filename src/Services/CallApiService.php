<?php

namespace App\Services;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallApiService
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }


    // Get All

    public function getClubs(): array
    {
        return $this->getApi('clubs');
    }

    public function getGens(): array
    {
        return $this->getApi('gens');
    }

    public function getDettes(): array
    {
        return $this->getApi('dettes');
    }

    private function getApi(string $ressource)
    {
        $response = $this->client->request(
            'GET',
            "http://localhost:8081/api/v1/$ressource"
        );

        return $response->toArray();
    }


    // Get By Id

    public function getClubsId($id): array
    {
        return $this->getApiId('clubs', $id);
    }

    public function getGensId($id): array
    {
        return $this->getApiId('gens', $id);
    }

    public function getDettesId($id): array
    {
        return $this->getApiId('dettes', $id);
    }

    private function getApiId(string $ressource, string $id)
    {
        $response = $this->client->request(
            'GET',
            "http://localhost:8081/api/v1/$ressource/$id"
        );

        return $response->toArray();
    }


    // Del by Id

    public function delClub($id)
    {
        $this->delApiId('clubs', $id);
    }

    public function delGens($id)
    {
        $this->delApiId('gens', $id);
    }

    public function delDette($id)
    {
        $this->delApiId('dettes', $id);
    }

    private function delApiId(string $ressource, string $id)
    {
        $this->client->request(
            'DELETE',
            "http://localhost:8081/api/v1/$ressource/$id"
        );
    }


    // Post

    public function postClub(array $data)
    {
        $this->postApi('clubs', $data);
    }

    public function postGens(array $data)
    {
        $data['clubId'] = "/api/v1/clubs/".$data['clubId'];
        $this->postApi('gens', $data);
    }

    public function postDette(array $data)
    {
        $data['gensId'] = "/api/v1/gens/".$data['gensId'];
        $this->postApi('dettes', $data);
    }

    private function postApi(string $ressource, array $data)
    {

        $data = json_encode($data);

        $this->client->request('POST', "http://localhost:8081/api/v1/$ressource", [
            'headers' => [
                'Content-Type: application/json',
                'Accept: application/json',
            ],
            'body' => $data
        ]);
    }


    // PATCH

    public function patchClub(array $data, string $id)
    {
        $this->patchApi('clubs', $data, $id);
    }

    public function patchGens(array $data, string $id)
    {
        $data['clubId'] = "/api/v1/clubs/".$data['clubId'];
        $this->patchApi('gens', $data, $id);
    }

    public function patchDette(array $data, string $id)
    {
        $data['gensId'] = "/api/v1/gens/".$data['gensId'];
        $this->patchApi('dettes', $data, $id);
    }

    private function patchApi(string $ressource, array $data, string $id)
    {

        $data = json_encode($data);

        /*$this->client->request('PATCH', "http://localhost:8081/api/v1/$ressource/$id", [
            'headers' => [
                'Content-Type: application/merge-patch+json'
            ],
            'body' => $data
        ]);*/

        $this->client->request('PATCH', "http://localhost:8081/api/v1/$ressource/$id", [
            'headers' => [
                'Content-Type: application/json'
            ],
            'body' => $data
        ]);
    }

}
