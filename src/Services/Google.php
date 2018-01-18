<?php

namespace DivArt\ShortLink\Services;

use DivArt\ShortLink\Exceptions\InvalidApiResponseException;

class Google extends Service
{
    /**
     * @throws InvalidApiResponseException
     */
    public function exceptions()
    {
        if (config('shortlink.google.url') == 'your_google_api_url' || config('shortlink.google.url') == null) {
            throw new InvalidApiResponseException('Use valid google api url in config/shortlink.php');
        }

        if (config('shortlink.google.key') == 'your_google_api_key' || config('shortlink.google.key') == null) {
            throw new InvalidApiResponseException('Use valid google api key in config/shortlink.php');
        }
    }

    /**
     * Returns a short url
     *
     * @param $longUrl
     * @param bool $withProtocol
     * @return string
     * @throws InvalidApiResponseException
     */
    public function google($longUrl, $withProtocol = true)
    {
        $this->exceptions();

        $this->validation(func_get_args()[0]);

        $response = $this->client->request('POST', config('shortlink.google.url') . '/url', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'query' => [
                'key' => config('shortlink.google.key')
            ],
            'body' => json_encode(['longUrl' => $longUrl])
        ]);

        $result = json_decode($response->getBody());

        switch ($response->getStatusCode()) {
            case '200':
                $result = json_decode($response->getBody());
                if ($withProtocol == false) {
                    $shortLink = parse_url($result->id);
        
                    return $shortLink['host'] . $shortLink['path'];
                }
                return $result->id;
                break;
        }  
    }

    /**
     * Returns click statistics
     *
     * @param $shortUrl
     * @return mixed
     * @throws InvalidApiResponseException
     *
     */
    public function clicks($shortUrl)
    {
        $this->exceptions();

        $this->validation(func_get_args());

        $response = $this->client->request('GET', config('shortlink.google.url') . '/url', [
            'query' => [
                'key' => config('shortlink.google.key'),
                'shortUrl' => $shortUrl,
                'projection' => 'ANALYTICS_CLICKS'
            ],
        ]);

        $result = json_decode($response->getBody());

        return $result->analytics->allTime->shortUrlClicks;
    }
}