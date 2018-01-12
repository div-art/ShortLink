# ShortLink
Short Link package for Laravel

## Installation

To install, run the following in your project directory:

``` bash
$ composer require div-art/shortlink
```

Then in config/app.php add the following to the providers array:

```
\DivArt\ShortLink\ShortLinkServiceProvider::class,
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

To publish Shorty's configuration file, run the following `vendor:publish` command:

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

ShortLink::googleStatistics($url);
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
