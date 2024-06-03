<?php
// Get the authentication token from the environment
$token = 'sxMYrKuF42RhTcABmidg_2Q9B0vkEdap-T4TwKyKzCD-DSZl1F4Jeun_euLfeTiLPfjYq7a4lSxyovuNe26z0w';

// Set the request headers
$headers = array(
    'Content-Type: application/json',
    'x-api-key: ' . $token
);

// Set the base API URL
//$baseApiUrl = 'https://public-api.escala.com/v1/crm/contacts';//usar parar crear contacto
$baseApiUrl = 'https://public-api.escala.com/v1/crm/contacts/67665df8-6f90-11ee-a3ea-c6f33f49b667/tags';

// Initialize a cURL session
$ch = curl_init($baseApiUrl);

// Set the request headers
$postData = array(
  'addTags' => array('724f8eb0-6f95-11ee-8079-c20120102465'),
  'triggerWorkflow' => false
);

// Set options for the cURL session
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

// Execute the cURL session
$response = curl_exec($ch);
$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

echo "<pre>";
print_r(json_decode($response));
print_r($statusCode);
echo "</pre>";
?>