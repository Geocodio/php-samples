<?php
/**
 * Geocodio Reverse Geocoding Example
 * This example shows you how to geocode a single coordinate using the
 * following endpoint:
 * 
 * GET /v1.4/reverse
 *
 * Note:
 * Remember to set your API Key in config.php
 */

require('config.php');

// This is the address that we want to geocode
$coordinate = '33.738987255507, -116.40833849559';

// Construct URL
$url = 'https://api.geocod.io/v1.4/reverse?q=' . urlencode($coordinate) . '&api_key=' . urlencode(API_KEY);

// Perform request and parse the JSON output
$response = json_decode(file_get_contents($url));

if ($response && count($response->results) > 0) {
	$firstResult = $response->results[0];

	// Print address components
	print_r($firstResult->address_components);

	// Print the full formatted address
	echo $firstResult->formatted_address;

} else {
	echo 'No results' . PHP_EOL;
}

/**
 * Example output:
 * 
 * stdClass Object
 * (
 *     [number] => 42331
 *     [street] => Bob Hope
 *     [suffix] => Dr
 *     [city] => Rancho Mirage
 *     [county] => Riverside County
 *     [state] => CA
 *     [zip] => 92270
 * )
 * 42331 Bob Hope Dr, Rancho Mirage, CA 92270
 */