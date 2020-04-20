<?php

namespace marchershey\Radarr;

use GuzzleHttp\Client;

class Radarr
{
    protected $url;
    protected $port;
    protected $apiKey;
    protected $user;
    protected $pass;

    public function __construct($url, $port, $apiKey, $user = null, $pass = null)
    {
        $this->url = $url . ':' . $port;
        $this->apiKey = $apiKey;
        $this->httpUser = $user;
        $this->httpPass = $pass;
    }

    /**
     * Search movies by term, TMDB ID, or IMDb ID
     *
     * @param string $searchBy Define what to search by - term (default) | tmdb | imdb
     * @param string $term (movie title) | tmdb id | imdb id
     *
     * @return string json encoded list of all locally installed movies
     */
    public function search($searchBy = 'term', $term)
    {
        if ($searchBy == 'term') {
            $request = [
                'type' => 'get',
                'endpoint' => 'movie/lookup',
                'params' => [
                    'term' => $term
                ]
            ];
        }

        if ($searchBy == 'tmdb') {
            $request = [
                'type' => 'get',
                'endpoint' => 'movie/lookup/tmdb',
                'params' => [
                    'tmdbId' => $term
                ]
            ];
        }

        if ($searchBy == 'imdb') {
            $request = [
                'type' => 'get',
                'endpoint' => 'movie/lookup/imdb',
                'params' => [
                    'imdbId' => $term
                ]
            ];
        }

        return $this->process($request);
    }


    public function process(array $request)
    {
        $client = new Client();
        $options = [
            'headers' => [
                'X-Api-Key' => $this->apiKey
            ]
        ];

        if ($request['type'] == 'get') {
            $url = $this->url . '/api/' . $request['endpoint'];
            $response = $client->request($request['type'], $url, $request['params']);

            return $response;
        }
    }
}
