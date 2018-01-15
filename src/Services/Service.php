<?php

namespace DivArt\ShortLink\Services;

class Service
{
    protected $client;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
    }

    /**
     * Returns the click statistics
     * based on the service on which the link is made
     *
     * @param $shortUrl
     * @return mixed
     */
    public function clicks($shortUrl)
    {
        $url = $this->isProtocol($shortUrl);

        $service = parse_url($url);

        switch($service['host']) {
            case 'goo.gl':
                $google = new Google();
                return $google->clicks($url);
                break;
            case 'bit.ly':
                $bitly = new Bitly();
                return $bitly->clicks($url);
                break;
            case 'rebrand.ly':
                $rebrandly = new Rebrandly();
                return $rebrandly->clicks($url);
                break;
        }
    }

    /**
     * See if the link has a protocol
     *
     * @param $shortUrl
     * @return string
     */
    public function isProtocol($shortUrl)
    {
        $url = parse_url($shortUrl);

        if (!isset($url['scheme'])) {
            return 'https://' . $shortUrl;
        }

        return $shortUrl;
    }
}