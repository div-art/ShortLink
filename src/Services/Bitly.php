<?php

namespace DivArt\ShortLink\Services;

use DivArt\ShortLink\Exceptions\InvalidApiResponseException;

class Bitly extends Service
{
    /**
     * @throws InvalidApiResponseException
     */
    public function exceptions()
    {
        if (config('shortlink.bitly.url') == 'your_bitly_api_url' || config('shortlink.bitly.url') == null) {
            throw new InvalidApiResponseException('Use valid bitly api url in config/shortlink.php');
        }

        if (config('shortlink.bitly.key') == 'your_bitly_api_key' || config('shortlink.bitly.key') == null) {
            throw new InvalidApiResponseException('Use valid bitly api key in config/shortlink.php');
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
    public function bitly($longUrl, $withProtocol = true)
    {
        $this->exceptions();

        $this->validation(func_get_args()[0]);

        $response = $this->client->request('POST', config('shortlink.bitly.url') . '/shorten', [
            'query' => [
                'longUrl' => $longUrl,
                'access_token' => config('shortlink.bitly.key'),
            ],
        ]);

        $result = json_decode($response->getBody());
        
        switch ($result->status_code) {
            case '200':
                if ($withProtocol == false) {
                    $shortLink = parse_url($result->data->url);

                    return $shortLink['host'] . $shortLink['path'];
                }

                return $result->data->url;
                break;
            case '500':
                throw new InvalidApiResponseException("Response $result->status_code: $result->status_txt");
            case '503':
                throw new InvalidApiResponseException("Response $result->status_code: $result->status_txt");
        }     
    }

    /**
     * Returns a long url
     *
     * @param $shortUrl
     * @return mixed
     * @throws InvalidApiResponseException
     */
    public function expand($shortUrl)
    {
        $this->exceptions();

        $response = $this->client->request('GET', config('shortlink.bitly.url') . '/expand', [
            'query' => [
                'access_token' => config('shortlink.bitly.key'),
                'shortUrl' => $shortUrl,
            ],
        ]);

        $result = json_decode($response->getBody());
 
        return $result->data->expand[0]->long_url;
    }

    /**
     * Returns click statistics
     *
     * @param $shortUrl
     * @return mixed
     * @throws InvalidApiResponseException
     */
    public function clicks($shortUrl)
    {
        $this->exceptions();

        $response = $this->client->request('GET', config('shortlink.bitly.url') . '/link/clicks', [
            'query' => [
                'access_token' => config('shortlink.bitly.key'),
                'link' => $shortUrl,
                'format' => 'txt',
            ],
        ]);

        $result = json_decode($response->getBody());

        return $result;
    }
}