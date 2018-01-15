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

        if (config('shortlink.bitly.clicks') == 'your_bitly_clicks_url' || config('shortlink.bitly.clicks') == null) {
            throw new InvalidApiResponseException('Use valid bitly api clicks url in config/shortlink.php');
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

        $response = $this->client->request('POST', config('shortlink.bitly.url'), [
            'query' => [
                'longUrl' => $longUrl,
                'access_token' => config('shortlink.bitly.key'),
            ],
        ]);

        $result = json_decode($response->getBody());

        if ($withProtocol == false) {
            $shortLink = parse_url($result->data->url);

            return $shortLink['host'] . $shortLink['path'];
        }

        return $result->data->url;
    }

    /**
     * Returns a long url
     *
     * @param $shortUrl
     * @return mixed
     * @throws InvalidApiResponseException
     */
    public function bitlyExpand($shortUrl)
    {
        $this->exceptions();

        $response = $this->client->request('GET', config('shortlink.bitly.expand'), [
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

        $response = $this->client->request('GET', config('shortlink.bitly.clicks'), [
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