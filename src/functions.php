<?php

/**
 * Create function shortLink if it is not exists
 */
if ( ! function_exists('shortLink')) {
    function shortLink()
    {
        return app('shortLink');
    }
}