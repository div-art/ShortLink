<?php

namespace DivArt\ShortLink\Interfaces;

use DivArt\ShortLink\Exceptions\InvalidApiResponseException;

abstract class ShortLinkAbstractInterface
{
    /**
     * Shortens the long given URL using bitly api
     *
     * @param $longUrl
     * @param $method
     * @return mixed
     * @throws InvalidApiResponseException
     */
    abstract public function bitly($longUrl, $method);

    /**
     * Shortens the long given URL using google api
     *
     * @param $longUrl
     * @param $method
     * @return mixed
     * @throws InvalidApiResponseException
     */
    abstract public function google($longUrl, $method);

    /**
     * Return google clicks stats
     *
     * @param $shortUrl
     * @param $method
     * @return mixed
     * @throws InvalidApiResponseException
     */
    abstract public function googleStats($shortUrl, $method);

    /**
     * Shortens the long given URL using default or given api
     *
     * @param $url
     * @param $api
     * @return mixed
     */
    abstract public function make($url, $api);
}