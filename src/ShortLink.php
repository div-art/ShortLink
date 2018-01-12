<?php

namespace DivArt\ShortLink;

use DivArt\ShortLink\Interfaces\ShortLinkAbstractInterface;
use DivArt\ShortLink\Exceptions\InvalidApiResponseException;

class ShortLink extends ShortLinkAbstractInterface
{
    /**
     * Converts a long URL into a short URL with the bit.ly/XXXXX format.
     *
     * @param $longUrl
     * @param string $method
     * @return mixed
     * @throws InvalidApiResponseException
     */
    public function bitly($longUrl, $method = 'post')
    {
        if (config('shortlink.bitly_api_url') == 'your_bitly_api_url' || config('shortlink.bitly_api_url') == null) {
            throw new InvalidApiResponseException('Use valid bitly api url in config/shortlink.php');
        }

        $client = new \GuzzleHttp\Client(['base_uri' => config('shortlink.bitly_api_url')]);

        $response = $client->request(strtoupper($method), config('shortlink.bitly_api_url'), [
            'query' => [
                'longUrl' => $longUrl,
                'access_token' => config('shortlink.bitly_api_key'),
            ],
        ]);

        $result = json_decode($response->getBody());

        return $result->data->url;
    }

    /**
     * Converts a long URL into a short URL with the goo.gl/XXXXX format.
     *
     * @param $longUrl
     * @param string $method
     * @return mixed
     * @throws InvalidApiResponseException
     */
    public function google($longUrl, $method = 'post')
    {   
        if (config('shortlink.google_api_url') == 'your_google_api_url' || config('shortlink.google_api_url') == null) {
            throw new InvalidApiResponseException('Use valid google api url in config/shortlink.php');
        }

        if (config('shortlink.google_api_key') == 'your_google_api_key' || config('shortlink.google_api_key') == null) {
            throw new InvalidApiResponseException('Use valid google api key in config/shortlink.php');
        }

        $client = new \GuzzleHttp\Client(['base_uri' => config('shortlink.google_api_url')]);

        $response = $client->request(strtoupper($method), config('shortlink.google_api_url'), [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'query' => [
                'key' => config('shortlink.google_api_key')
            ],
            'body' => json_encode(array('longUrl' => $longUrl))
        ]);

        $result = json_decode($response->getBody());

        return $result->id;
    }

    /**
     * Return google clicks stats
     *
     * @param $shortUrl
     * @param string $method
     * @return mixed
     * @throws InvalidApiResponseException
     */
    public function googleStats($shortUrl, $method = 'get')
    {
        if (config('shortlink.google_api_url') == 'your_google_api_url' || config('shortlink.google_api_url') == null) {
            throw new InvalidApiResponseException('Use valid google api url in config/shortlink.php');
        }

        if (config('shortlink.google_api_key') == 'your_google_api_key' || config('shortlink.google_api_key') == null) {
            throw new InvalidApiResponseException('Use valid google api key in config/shortlink.php');
        }

        $client = new \GuzzleHttp\Client(['base_uri' => config('shortlink.google_api_url')]);

        $response = $client->request(strtoupper($method), config('shortlink.google_api_url'), [
            'query' => [
                'key' => config('shortlink.google_api_key'),
                'shortUrl' => $shortUrl,
                'projection' => 'ANALYTICS_CLICKS'
            ],
        ]);

        $result = json_decode($response->getBody());

        return $result->analytics->allTime->shortUrlClicks;
    }

    /**
     * Shortens the long given URL using default or given api
     *
     * @param $url
     * @param null $api
     * @return mixed|string
     * @throws InvalidApiResponseException
     */
    public function make($url, $api = null)
    {
        $api ? $api : $api = config('shortlink.default_api');

        switch ($api) {
            case 'google':
                return $this->google($url);
                break;
            case 'bitly':
                return $this->bitly($url);
                break;
            default:
                return 'This api not found!';
        }
    }
}