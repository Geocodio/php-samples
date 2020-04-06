<?php
/**
 * Geocodio Batch Reverse Geocoding Example
 * This example shows you how to reverse geocode up to 10,000 coordinates at once using the
 * batch reverse geocoding endpoint.
 * 
 * POST /v1.4/reverse
 *
 * Note:
 * Remember to set your API Key in config.php
 */

require('config.php');

// Construct URL
$url = 'https://api.geocod.io/v1.4/reverse?api_key=' . urlencode(API_KEY);

// Define coordinates to geocode
$coordinates = [
	'35.9746000,-77.9658000',
	'32.8793700,-96.6303900',
	'33.8337100,-117.8362320',
	'35.4171240,-80.6784760'
];

// Encode coordinates into JSON
$json = json_encode($coordinates);

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

		// Print address components
		print_r($firstResult->address_components);

		// Print the full formatted address
		echo $firstResult->formatted_address;
	} else {
		echo 'No results';
	}

	echo PHP_EOL . PHP_EOL; // Line break
}

/**
 * Example output:
 * 
 * Input: 35.9746000,-77.9658000
 * Output: stdClass Object
 * (
 *     [number] => 101
 *     [street] => State Hwy 58
 *     [city] => Nashville
 *     [county] => Nash County
 *     [state] => NC
 *     [zip] => 27856
 * )
 * 101 State Hwy 58, Nashville, NC 27856
 * 
 * Input: 32.8793700,-96.6303900
 * Output: stdClass Object
 * (
 *     [number] => 100
 *     [predirectional] => E
 *     [street] => Kingsley
 *     [suffix] => Rd
 *     [city] => Garland
 *     [county] => Dallas County
 *     [state] => TX
 *     [zip] => 75041
 * )
 * 100 E Kingsley Rd, Garland, TX 75041
 * 
 * Input: 33.8337100,-117.8362320
 * Output: stdClass Object
 * (
 *     [number] => 2700
 *     [predirectional] => N
 *     [street] => Tustin
 *     [suffix] => St
 *     [city] => Orange
 *     [county] => Orange County
 *     [state] => CA
 *     [zip] => 92865
 * )
 * 2700 N Tustin St, Orange, CA 92865
 * 
 * Input: 35.4171240,-80.6784760
 * Output: stdClass Object
 * (
 *     [number] => 5968
 *     [street] => Village
 *     [suffix] => Dr
 *     [postdirectional] => NW
 *     [city] => Concord
 *     [county] => Cabarrus County
 *     [state] => NC
 *     [zip] => 28027
 * )
 * 5968 Village Dr NW, Concord, NC 28027
 */