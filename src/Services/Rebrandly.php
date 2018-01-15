<?php

namespace DivArt\ShortLink\Services;

use DivArt\ShortLink\Exceptions\InvalidApiResponseException;

class Rebrandly extends Service
{
    /**
     * @throws InvalidApiResponseException
     */
    public function exceptions()
    {
        if (config('shortlink.rebrandly.url') == 'your_rebrandly_api_url' || config('shortlink.rebrandly.url') == null) {
            throw new InvalidApiResponseException('Use valid rebrandly api url in config/shortlink.php');
        }

        if (config('shortlink.rebrandly.key') == 'your_rebrandly_api_key' || config('shortlink.rebrandly.key') == null) {
            throw new InvalidApiResponseException('Use valid rebrandly api key in config/shortlink.php');
        }
    }

    /**
     * Returns a short url
     *
     * @param $longUrl
     * @return string
     * @throws InvalidApiResponseException
     */
    public function rebrandly($longUrl)
    {   
        $this->exceptions();

        $response = $this->client->request('POST', config('shortlink.rebrandly.url'), [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'query' => [
                'apikey' => config('shortlink.rebrandly.key')
            ],
            'body' => json_encode(array('destination' => $longUrl))
        ]);

        $result = json_decode($response->getBody());

        return $result->shortUrl;
    }

    /**
     * Returns click statistics
     *
     * @param $shortUrl
     * @return mixed
     */
    public function clicks($shortUrl)
    {   
        //$this->exceptions();

        $response = $this->client->request('POST', config('shortlink.rebrandly.url'), [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'query' => [
                'apikey' => config('shortlink.rebrandly.key')
            ],
            'body' => json_encode(array('destination' => $shortUrl))
        ]);

        $result = json_decode($response->getBody());

        return $result->clicks;
    }
}