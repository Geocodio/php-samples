<?php
/**
 * Geocodio Geocoding Example
 * This example shows you how to geocode a single address using the
 * following endpoint:
 * 
 * GET /v1/geocode
 *
 * Note:
 * Remember to set your API Key in config.php
 */

require('config.php');

// This is the address that we want to geocode
$address = '42370 Bob Hope Drive, Rancho Mirage CA';

// Construct URL
$url = 'https://api.geocod.io/v1/geocode?q=' . urlencode($address) . '&api_key=' . urlencode(API_KEY);

// Perform request and parse the JSON output
$response = json_decode(file_get_contents($url));

if ($response && count($response->results) > 0) {
	$firstResult = $response->results[0];

	echo $firstResult->location->lat . ', ' . $firstResult->location->lng . PHP_EOL;

} else {
	echo 'No results' . PHP_EOL;
}

/**
 * Example output:
 * 
 * 33.738987255507, -116.40833849559
 */