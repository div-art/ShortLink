# ShortLink
Short Link package for Laravel 5.5

## Installation

To install, run the following in your project directory:

``` bash
$ composer require div-art/shortlink
```

Then in `config/app.php` add the following to the `providers` array:

```
\DivArt\ShortLink\ShortLinkServiceProvider::class,
```

Also in `config/app.php`, add the Facade class to the `aliases` array:

```
'ShortLink' => \DivArt\ShortLink\Facades\ShortLink::class,
```

## Configuration

To publish ShortLink's configuration file, run the following `vendor:publish` command:

```
php artisan vendor:publish --provider="DivArt\ShortLink\ShortLinkServiceProvider"
```

This will create a shortlink.php in your config directory. Here you must enter your Shortener URL API Key.

## Usage

**Be sure to include the namespace for the class wherever you plan to use this library**

```
use DivArt\ShortLink\Facades\ShortLink;
```

To shorten a URL:

``` php
$url = "https://www.google.com";

ShortLink::google($url);

// return https://goo.gl/Njku
```

To get stats of clicks on shortened URL:

``` php
$url = https://goo.gl/Njku;

ShortLink::clicks($url);
```

## Methods

``` php
ShortLink::google(); // return shortener url like goo.gl/XXXXXX

ShortLink::bitly(); // return shortener url like bit.ly/XXXXXX

ShortLink::rebrandly(); // return shortener url like rebrand.ly/XXXXXX

ShortLink::clicks(); // return count of clicks on a shortener url

ShortLink::expand(); // return long url
```

## Services

[goo.gl](https://developers.google.com/url-shortener/)

[bit.ly](https://dev.bitly.com/)

[rebrand.ly](https://developers.rebrandly.com/)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
