<?php
/**
 * Geocodio Batch Geocoding Example
 * This example shows you how to geocode up to 10,000 addresses at once using the
 * batch geocoding endpoint.
 * 
 * POST /v1.3/geocode
 *
 * Note:
 * Remember to set your API Key in config.php
 */

require('config.php');

// Construct URL
$url = 'https://api.geocod.io/v1.3/geocode?api_key=' . urlencode(API_KEY);

// Define addresses to geocode
$addresses = [
	'42370 Bob Hope Drive, Rancho Mirage CA',
	'1290 Northbrook Court Mall, Northbrook IL',
	'4410 S Highway 17 92, Casselberry FL',
	'15000 NE 24th Street, Redmond WA',
	'17015 Walnut Grove Drive, Morgan Hill CA'
];

// Encode addresses into JSON
$json = json_encode($addresses);

// Create CURL request
$ch = curl_init($url);

// Very large batch requests can take a couple of minutes to run, so we make sure to give plenty
// of room before timing out.
curl_setopt($ch, CURLOPT_TIMEOUT, 60 * 10);

// General CURL options
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $json);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($json)
]);

// Get response and decode the JSON
$response = json_decode(curl_exec($ch));
curl_close($ch);

if (!isset($response->results)) {
	echo 'Error!';
	var_dump($response);
}

// Output decoded json
foreach ($response->results as $result) {
	echo 'Input: ' . $result->query . PHP_EOL;

	$geocodeResults = $result->response->results;

	echo 'Output: ';
	if (count($geocodeResults) > 0) {
		$firstResult = $geocodeResults[0];

		echo $firstResult->location->lat . ', ' . $firstResult->location->lng;
	} else {
		echo 'No results';
	}

	echo PHP_EOL . PHP_EOL; // Line break
}

/**
 * Example output:
 * 
 * Input: 42370 Bob Hope Drive, Rancho Mirage CA
 * Output: 33.738987255507, -116.40833849559
 * 
 * Input: 1290 Northbrook Court Mall, Northbrook IL
 * Output: 42.120176, -87.838815
 * 
 * Input: 4410 S Highway 17 92, Casselberry FL
 * Output: 28.661468, -81.313989
 * 
 * Input: 15000 NE 24th Street, Redmond WA
 * Output: 47.63150504878, -122.14160607317
 * 
 * Input: 17015 Walnut Grove Drive, Morgan Hill CA
 * Output: 37.148936142857, -121.68332857143
 */