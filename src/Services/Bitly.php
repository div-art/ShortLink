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

        $url = parse_url($longUrl);
        if ( ! isset($url['scheme'])) {
            $longUrl = 'http://' . $longUrl;
        }

        $response = $this->client->request('POST', config('shortlink.bitly.url') . '/shorten', [
            'headers' => [
				'Authorization' => 'Bearer '.config('shortlink.bitly.key'),
				'Content-Type' => 'application/json',
			],
            'json' => [
                'long_url' => $longUrl,
            ],
        ]);

        $result = json_decode($response->getBody());
        $status_code = $response->getStatusCode();
        $status_text = $response->getReasonPhrase();

        switch ($status_code) {
            case '200':
                if ($withProtocol == false) {
                    $bitly = $result->id;
                } else {
                    $bitly = $result->link;
                }

                return $bitly;
                break;
            case '201':
                if ($withProtocol == false) {
                    $bitly = $result->id;
                } else {
                    $bitly = $result->link;
                }

                return $bitly;
                break;
            case '400':
                throw new InvalidApiResponseException("Response $status_code: $status_text");
            case '403':
                throw new InvalidApiResponseException("Response $status_code: $status_text");
            case '417':
                throw new InvalidApiResponseException("Response $status_code: $status_text");
            case '422':
                throw new InvalidApiResponseException("Response $status_code: $status_text");
            case '500':
                throw new InvalidApiResponseException("Response $status_code: $status_text");
            case '503':
                throw new InvalidApiResponseException("Response $status_code: $status_text");
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

        $response = $this->client->request('POST', config('shortlink.bitly.url') . '/expand', [
            'headers' => [
				'Authorization' => 'Bearer '.config('shortlink.bitly.key'),
				'Content-Type' => 'application/json',
			],
            'json' => [
                'bitlink_id' => $shortUrl,
            ],
        ]);

        $result = json_decode($response->getBody());

        return $result->long_url;
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