<?php
require_once(dirname(__FILE__) . '/config.php');

$request_url = "https://$icinga_host:5665/v1/objects/services";
$headers = array(
        'Accept: application/json',
        'X-HTTP-Method-Override: GET'
);
$data = array(
	'attrs' => array('state', 'host_name', 'display_name', 'state', 'last_check_result', 'last_state_change'),
	'filter' => $filter
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
$icinga_service_data = array();
foreach($response['results'] as $result) {
	$attrs = $result['attrs'];

	$state = $attrs['state'];
	$host_name = $attrs['host_name'];
	$display_name = $attrs['display_name'];

	if(!isset($icinga_service_data[$host_name])) {
		$icinga_service_data[$host_name] = array();
	}
	$icinga_service_data[$host_name][$display_name] = $attrs;
}


