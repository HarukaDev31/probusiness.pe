<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Listado de Registros Curso de Importación</title>
  </head>
  <body>
    <h1 class="text-center">Lista de registros</h1>
<?php 

/**
 * Creates a contact using the provided data.
 *
 * @param mixed $data The data for creating the contact.
 * @return string|null The response from the API, or null if an error occurred.
 */
function createContact($data) {
    try {
        // Get the authentication token from the environment
        $token = 'sxMYrKuF42RhTcABmidg_2Q9B0vkEdap-T4TwKyKzCD-DSZl1F4Jeun_euLfeTiLPfjYq7a4lSxyovuNe26z0w';

        // Set the request headers
        $headers = array(
            'Content-Type: application/json',
            'x-api-key: ' . $token
        );

        // Set the base API URL
        //$baseApiUrl = 'https://public-api.escala.com/v1/crm/contacts';//usar parar crear contacto
        $baseApiUrl = 'https://public-api.escala.com/v1/crm/contacts';

        // Initialize a cURL session
        $ch = curl_init($baseApiUrl);

        // Set options for the cURL session
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));//usar para crear contacto

        // Execute the cURL session
        $response = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($statusCode == 201) {
          echo 'Contact Created';
        } else {
          //echo $response;
        }

        // Close the cURL session
        curl_close($ch);

        return $response;
    } catch (Exception $ex) {
        echo 'An exception occurred: ' . $ex->getMessage();
    }

    return null;
}

// Example usage - usar para crear contacto
$data = array(
  "assignedTo" => "unassigned",
  "company" => array(
    "annualRevenue" => 10000000,
    "email" => "company@email.com",
    "industryType" => "agriculture",
    "name" => "Acme Inc",
    "numberOfEmployees" => 20,
    "phoneNumber" => "56912345678",
    "website" => "https://acme.com"
  ),
  "contacted" => true,
  "notes" => "Note",
  "personal" => array(
    "address" => "1234 Street",
    "birthDay" => 28,
    "birthMonth" => 2,
    "birthYear" => 1998,
    "city" => "City",
    "country" => "USA",
    "email" => "contact@email.com",
    "facebook" => "https://www.facebook.com/user_name",
    "firstName" => "Monica",
    "instagram" => "@user_name",
    "jobTitle" => "Project Manager",
    "lastName" => "Geller",
    "linkedIn" => "https://www.linkedin.com/in/user_name",
    "phoneNumber" => "56912345678",
    "region" => "Region",
    "secondaryPhoneNumber" => "56912345670",
    "state" => "State",
    "twitter" => "@user_name"
  ),
  "priority" => 0,
  "source" => "referrer",
  "status" => "lead",
  "triggerWorkflow" => false
);

$response = createContact($data);

//echo "<pre>";
//print_r($response);
$response = json_decode($response, true);
//var_dump($response);
//echo "</pre>";

?>

<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th scope="col">F. Registro</th>
      <th scope="col">Email</th>
      <th scope="col">Elige tu membresía</th>
      <th scope="col">Nombre</th>
      <th scope="col">Edad</th>
      <th scope="col">Sexo</th>
      <th scope="col">DNI o RUC</th>
      <th scope="col">Teléfono</th>
      <th scope="col">¿En qué rubro estás Interesad@?</th>
      <th scope="col">Departamento</th>
      <th scope="col">Provincia</th>
      <th scope="col">Distrito</th>
      <th scope="col">Fechas y Horarios</th>
    </tr>
  </thead>
  <tbody>
  <?php
  foreach($response['items'] as $row){
    if(isset($row['custom']['cf_contact_elige_tu_membresia_myus_dropdown'])){
      /*
      echo "<pre>";
      var_dump($row);
      echo "</pre>";
      */
      ?>
          <tr>
            <th><?php echo $row['created']; ?></th>
            <th><?php echo $row['personal']['email']; ?></th>
            <th><?php echo $row['custom']['cf_contact_elige_tu_membresia_myus_dropdown']; ?></th>
            <th><?php echo $row['personal']['firstName']; ?></th>
            <th><?php echo $row['custom']['cf_contact_edad_tuxk_number']; ?></th>
            <th><?php echo $row['custom']['cf_contact_sexo_pder_dropdown']; ?></th>
            <th><?php echo $row['custom']['cf_contact_dni_o_ruc_qatn_number']; ?></th>
            <th><?php echo $row['personal']['phoneNumber']; ?></th>
            <th><?php echo $row['custom']['cf_en_que_rubro_estas_interesad_bkvd_dropdown']; ?></th>
            <th><?php echo $row['custom']['cf_contact_departamento_ukma_text']; ?></th>
            <th><?php echo $row['custom']['cf_contact_provincia_quir_text']; ?></th>
            <th><?php echo $row['custom']['cf_contact_distrito_uyaj_text']; ?></th>
            <th><?php echo $row['custom']['cf_contact_fechas_y_horarios_vsuv_dropdown']; ?></th>
          </tr>
      <?php
    }
  }
  ?>
  </tbody>
</table>

<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
-->
</body>
</html>