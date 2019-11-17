<?php
require_once('config.php');

$request_url = "https://$icinga_host:5665/v1/objects/services";
$headers = array(
        'Accept: application/json',
        'X-HTTP-Method-Override: GET'
);
$data = array(
        'attrs' => array('state', 'last_check_result', 'last_state_change'),
        'filter' => "host.name == \"$host\" && service.name == \"https\"",
);

$ch = curl_init();
curl_setopt_array($ch, array(
        CURLOPT_URL => $request_url,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_USERPWD => $api_username . ":" . $api_password,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => count($data),
        CURLOPT_POSTFIELDS => json_encode($data)
));

$response = curl_exec($ch);
if ($response === false) {
        die();
}

$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($code != 200) {
        die();
}
$response = json_decode($response, true);

if (count($response['results']) != 1) {
	die();
}

$last_check = $response['results'][0]['attrs']['last_check_result']['execution_start'];
$current_state = $response['results'][0]['attrs']['state'];
$last_change = $response['results'][0]['attrs']['last_state_change'];


