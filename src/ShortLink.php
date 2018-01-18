<?php

namespace DivArt\ShortLink;

use DivArt\ShortLink\Interfaces\ShortLinkAbstractInterface;
use DivArt\ShortLink\Exceptions\InvalidApiResponseException;
use DivArt\ShortLink\Services\Bitly;
use DivArt\ShortLink\Services\Google;
use DivArt\ShortLink\Services\Rebrandly;
use DivArt\ShortLink\Services\Service;

class ShortLink
{

    /**
     * Returns a short url using the bitly service
     *
     * @param $longUrl
     * @param bool $withProtocol
     * @return string
     * @throws InvalidApiResponseException
     */
    public function bitly($longUrl, $withProtocol = true)
    {
        $bitly = new Bitly();

        return $bitly->bitly($longUrl, $withProtocol);
    }

    /**
     * Returns a long url using the bitly service
     *
     * @param $shortUrl
     * @return mixed
     * @throws InvalidApiResponseException
     */
    public function expand($shortUrl)
    {
        $servise = new Service();

        return $servise->expand($shortUrl);
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
        $servise = new Service();

        return $servise->clicks($shortUrl);
    }

    /**
     * Returns a short url using the google service
     *
     * @param $longUrl
     * @param bool $withProtocol
     * @return string
     * @throws InvalidApiResponseException
     */
    public function google($longUrl, $withProtocol = true)
    {   
        $google = new Google();

        return $google->google($longUrl, $withProtocol);
    }

    /**
     * Returns a short url using the rebrandly service
     *
     * @param $longUrl
     * @param bool $withProtocol
     * @return string
     * @throws InvalidApiResponseException
     */
    public function rebrandly($longUrl, $withProtocol = true)
    {   
        $rebrandly = new Rebrandly();

        return $rebrandly->rebrandly($longUrl, $withProtocol);
    }

    /**
     * Calls the method specified in the configuration
     *
     * @param $url
     * @param bool $withProtocol
     * @return string
     * @throws InvalidApiResponseException
     */
    public function make($url, $withProtocol = true)
    {
        $api = config('shortlink.driver');

        switch ($api) {
            case 'google':
                return $this->google($url, $withProtocol);
                break;
            case 'bitly':
                return $this->bitly($url, $withProtocol);
                break;
            case 'rebrandly':
                return $this->rebrandly($url, $withProtocol);
                break;
            default:
                throw new InvalidApiResponseException('This api not found!');
                break;
        }
    }
}