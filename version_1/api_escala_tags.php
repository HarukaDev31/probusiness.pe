<?php
// Get the authentication token from the environment
$token = 'sxMYrKuF42RhTcABmidg_2Q9B0vkEdap-T4TwKyKzCD-DSZl1F4Jeun_euLfeTiLPfjYq7a4lSxyovuNe26z0w';

// Set the request headers
$headers = array(
    'Content-Type: application/json',
    'x-api-key: ' . $token
);

// Set the base API URL
$baseApiUrl = 'https://public-api.escala.com/v1/crm/tags';

// Initialize a cURL session
$ch = curl_init($baseApiUrl);

// Set options for the cURL session
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// Execute the cURL session
$response = curl_exec($ch);
$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);


// Close the cURL session
curl_close($ch);

echo "<pre>";
print_r($response);
echo "</pre>";

//"7da9a4f8-6f95-11ee-88b0-52a8440778fb","name":"plan_empresarial"
//"78ce53ac-6f95-11ee-bfac-ae897aec92db","name":"plan_premium"
//"724f8eb0-6f95-11ee-8079-c20120102465","name":"plan_emprendedor"
?>