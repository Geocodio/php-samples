# Geocodio PHP Samples

This is simple PHP examples that shows you how to use the various Geocoding endpoints.

* **geocode.php** For geocoding a single address into coordinates
* **reverse_geocode.php** For reverse geocoding a single coordinates into addresses
* **batch_geocode.php** For batch geocoding up to 10,000 addresses
* **batch_reverse_geocode.php** For batch reverse geocoding up to 10,000 coordinate

## Configuration

Just make sure to set your API KEY in `config.php`. You can find and create your own API key at [https://dash.geocod.io](https://dash.geocod.io).

## A little note
These examples are just for basic usage and doesn't contain much error handling. For production usage we recommend a more sophisticated library such as David Stanley's excellent [PHP Library for Geocodio](https://github.com/davidstanley01/geocodio-php).