<?php

namespace DivArt\ShortLink\Services;

use DivArt\ShortLink\Exceptions\InvalidApiResponseException;

class Service
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * Service constructor.
     */
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
            default:
                return $this->validation($shortUrl);
                break;
        }
    }

    /**
     * Returns long url
     * based on the service on which the link is made
     *
     * @param $shortUrl
     * @return mixed
     */
    public function expand($shortUrl)
    {
        $url = $this->isProtocol($shortUrl);

        $bitly = new Bitly();
        return $bitly->expand($url);
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

        if (isset($url['scheme'])) {
            $shortUrl = str_replace('https://', '', $shortUrl);
            return $shortUrl;
        }

        return $shortUrl;
    }

    /**
     * Validate url and parameters
     *
     * @param array ...$arr
     * @throws InvalidApiResponseException
     */
    public function validation(...$arr)
    {
        if (isset($arr[0])) {
            if ( ! $this->isUrl($arr[0])) {
                throw new InvalidApiResponseException('Your url is not valid.');
            }

            if ( ! isset($arr[0]) || gettype($arr[0]) != 'string') {
                throw new InvalidApiResponseException('Invalid argument, expect a string, ' . gettype($arr[0]) . ' given.');
            }
        } else {
            throw new InvalidApiResponseException('Missing parameter');
        }

        if (isset($arr[1])) {
            if ( ! isset($arr[1]) || gettype($arr[1]) != 'boolean') {
                throw new InvalidApiResponseException('Invalid argument, expect a boolean, ' . gettype($arr[1]) . ' given.');
            }
        }
    }

    /**
     * Checking the URL for validity
     *
     * @param $url
     * @return false|int
     */
    public function isUrl($url)
    {
        return  preg_match('|^(http(s)?://)?([a-z]+.)?[a-z0-9-]+\.([a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
    }
}