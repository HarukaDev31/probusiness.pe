<?php
// Get the authentication token from the environment
$token = 'sxMYrKuF42RhTcABmidg_2Q9B0vkEdap-T4TwKyKzCD-DSZl1F4Jeun_euLfeTiLPfjYq7a4lSxyovuNe26z0w';

// Set the request headers
$headers = array(
  'Content-Type: application/json',
  'x-api-key: ' . $token
);

//data params
$iIdContact = $_POST['id'];
$iIdTag = $_POST['id_etiqueta'];

// Set the base API URL
$baseApiUrl = 'https://public-api.escala.com/v1/crm/contacts/' . $iIdContact . '/tags';

// Initialize a cURL session
$ch = curl_init($baseApiUrl);

// Set the request headers
$postData = array(
  'addTags' => array($iIdTag),
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

if ($statusCode == 200) {
  echo json_encode(array(
    'status' => 'success',
    'message' => "Actualizado"
  ));
  exit;
} else {
  echo json_encode(array(
    'status' => 'error',
    'message' => "Problemas al actualizar",
    'result' => $response
  ));
  exit;
}
?>