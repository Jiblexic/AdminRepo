<?php

// create a new cURL resource
$ch = curl_init();

// set URL and other appropriate options
$url = "http://api.twittercounter.com/?apikey=e9335031a759f251ee9b4e2e6634e1c5&twitter_id=15160529";

//  Initiate curl
$ch = curl_init();
// Disable SSL verification
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// Will return the response, if false it print the response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Set the url
curl_setopt($ch, CURLOPT_URL,$url);
// Execute
$result=curl_exec($ch);
// Closing
curl_close($ch);

// Will dump a beauty json :3
$decodedJson = (json_decode($result, true));

echo $decodedJson['followers_current'];

?>