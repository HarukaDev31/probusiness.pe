<?php

//developer
error_reporting(-1);
ini_set('display_errors', 1);


//production
/*
ini_set('display_errors', 0);
if (version_compare(PHP_VERSION, '5.3', '>='))
{
  error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
}
else
{
  error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
}
*/

function ToDateBD($date){
	$d = explode('-', $date);
	return $d[2] . '/' . $d[1] . '/' . $d[0];
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css" rel="stylesheet">

    <title>Listado de Registros Curso de Importación</title>
  </head>
  <body>
    <section class="py-5 text-center container">
      <div class="row py-lg-1">
        <div class="col-md-12 mx-auto">
          <h1 class="text-center mb-4">Lista de registros</h1>
          <div class="table-responsive">
          <?php
          
          function listContact() {
              try {
                  // Get the authentication token from the environment
                  $token = 'sxMYrKuF42RhTcABmidg_2Q9B0vkEdap-T4TwKyKzCD-DSZl1F4Jeun_euLfeTiLPfjYq7a4lSxyovuNe26z0w';

                  // Set the request headers
                  $headers = array(
                      'Content-Type: application/json',
                      'x-api-key: ' . $token
                  );

                  // Set the base API URL
                  $baseApiUrl = 'https://public-api.escala.com/v1/crm/contacts';

                  // Initialize a cURL session
                  $ch = curl_init($baseApiUrl);

                  // Set options for the cURL session
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

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

          $response = listContact();

          $response = json_decode($response, true);

          //echo "<pre>";
          //var_dump($response);
          //echo "</pre>";

          ?>

          <table id="example" class="table table-striped table-hover">
            <thead>
              <tr>
                <th class="col">Usuario</th>
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
                <th scope="col">Usuario</th>
                <th scope="col">Contraseña</th>
              </tr>
            </thead>
            <tbody>
            <?php
            foreach($response['items'] as $row){
              if(isset($row['custom']['cf_en_que_rubro_estas_interesad_bkvd_dropdown'])){
                
                $firstName = trim($row['personal']['firstName']);
                //$email = trim($row['personal']['email']) . '11';
                $email = trim($row['personal']['email']);

                $username = explode("@", $email);
                //$username = $username[0] . '11';
                $username = $username[0];

                $password = strtoupper(substr($username,0,1)) . substr($username,1,strlen($username)) . date('Y') . date('m') . '$';
                
                $arrDate =  explode("T", $row['created']);

                $phoneNumber = $row['personal']['phoneNumber'];

                $sMembresia = (isset($row['custom']['cf_contact_elige_tu_membresia_myus_dropdown']) ? $row['custom']['cf_contact_elige_tu_membresia_myus_dropdown'] : 'Renovación');
                ?>
                    <tr>
                      <td>
                        <button type="button" id="btn-crear-<?php echo $row['id']; ?>"
                          data-id="<?php echo $row['id']; ?>"
                          data-username="<?php echo $username; ?>"
                          data-password="<?php echo $password; ?>"
                          data-firstname="<?php echo $firstName; ?>"
                          data-email="<?php echo $email; ?>"
                          data-phone="<?php echo $phoneNumber; ?>"
                          class="btn btn-primary btn-crear_usuario" alt="Crear usuario" title="Crear usuario" href="javascript:void(0)">
                          Crear
                        </button>
                      </td>
                      <td><?php echo ToDateBD($arrDate[0]); ?></td>
                      <td><?php echo $email; ?></td>
                      <td><?php echo $sMembresia; ?></td>
                      <td><?php echo $firstName; ?></td>
                      <td><?php echo $row['custom']['cf_contact_edad_tuxk_number']; ?></td>
                      <td><?php echo $row['custom']['cf_contact_sexo_pder_dropdown']; ?></td>
                      <td><?php echo $row['custom']['cf_contact_dni_o_ruc_qatn_number']; ?></td>
                      <td><?php echo $phoneNumber; ?></td>
                      <td><?php echo $row['custom']['cf_en_que_rubro_estas_interesad_bkvd_dropdown']; ?></td>
                      <td><?php echo $row['custom']['cf_contact_departamento_ukma_text']; ?></td>
                      <td><?php echo $row['custom']['cf_contact_provincia_quir_text']; ?></td>
                      <td><?php echo $row['custom']['cf_contact_distrito_uyaj_text']; ?></td>
                      <td><?php echo $row['custom']['cf_contact_fechas_y_horarios_vsuv_dropdown']; ?></td>
                      <td><?php echo $username; ?></td>
                      <td><?php echo $password; ?></td>
                    </tr>
                <?php
              }
            }
            ?>
            </tbody>
          </table>
          </div>
        </div>
      </div>
    </section>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>

    <script>
      $(document).ready(function() {
        var table = $('#example').DataTable( {
          'dom': 'B<"top">frt<"bottom"lip><"clear">',
          buttons: [{
            extend    : 'excel',
            text      : 'Excel',
            titleAttr : 'Excel',
            exportOptions: {
              columns: ':visible'
            }
          },
          /*
          {
            extend    : 'pdf',
            text      : 'PDF',
            titleAttr : 'PDF',
            exportOptions: {
              columns: ':visible'
            }
          },{
            extend    : 'copy',
            text      : 'Copiar',
            titleAttr : 'Copiar',
            exportOptions: {
              columns: ':visible'
            }
          },{
            extend    : 'colvis',
            text      : 'Columnas',
            titleAttr : 'Columnas',
            exportOptions: {
              columns: ':visible'
            }
          },
          */
          ],
          'oLanguage' : {
            'sInfo'               : 'Mostrando (_START_ - _END_) total de registros _TOTAL_',
            'sLengthMenu'         : '_MENU_',
            'sSearch'             : 'Buscar por: ',
            'sSearchPlaceholder'  : '',
            'sZeroRecords'        : 'No se encontraron registros',
            'sInfoEmpty'          : 'No hay registros',
            'sLoadingRecords'     : 'Cargando...',
            'sProcessing'         : 'Procesando...',
            'oPaginate'           : {
              'sFirst'    : '<<',
              'sLast'     : '>>',
              'sPrevious' : '<',
              'sNext'     : '>',
            },
          },
          'columnDefs': [
            {
              'targets': 'no-hidden',
              "visible": false, 
            },
          ],
          'lengthMenu': [[100, 500, 1000, -1], [100, 500, 1000, 10000]],
        });

        table.buttons().container().appendTo( '#example_wrapper .col-md-6:eq(0)' );

        $('.dataTables_length').addClass('col-xs-4 col-sm-5 col-md-1');
        $('.dataTables_info').addClass('col-xs-8 col-sm-7 col-md-4');
        $('.dataTables_paginate').addClass('col-xs-12 col-sm-12 col-md-7');

        $( '.btn-crear_usuario' ).click(function(e){
          e.preventDefault();

          var id = $(this).data('id');
          var username = $(this).data('username');
          var password = $(this).data('password');
          var phone = $(this).data('phone');
          var firstname = $(this).data('firstname');
          var email = $(this).data('email');

          $( '#btn-crear-' + id ).text('');
          $( '#btn-crear-' + id ).attr('disabled', true);
          $( '#btn-crear-' + id ).html( '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>' );

          var arrParams = {
            evento: 'crear_usuario',
            username: username,
            password: password,
            firstname: firstname,
            email: email
          };

          $.ajax({
            type : 'POST',
            dataType : 'JSON',
            url : 'MoodleRestPro.php',
            data : arrParams,
            success : function( response ){
              console.log(response);
              
              alert(response['message']);

              if(response['status']=='success') {
                $.ajax({
                  type : 'POST',
                  dataType : 'JSON',
                  url : 'sendemail.php',
                  data : arrParams,
                  success : function( response ){
                    //url = 'https://wa.me/' + phone + '?text=';
                    url = 'https://api.whatsapp.com/send?phone=' + phone + '&text=';
                    url += 'Listo🙌🏻 ' + firstname + ' para poder acceder a nuestra Aula Virtual 👨🏼‍🏫 le comparto su Usuario y Contraseña para que pueda ingresar: 👇🏼📚 \n\n';
                    url += '✅Usuario: ' + username + '\n';
                    url += '✅Contraseña: ' + password;
                    url += '\n\n💻Link de Nuestra plataforma: https://aulavirtualprobusiness.com/login/index.php';
                    url += '\n\n📁Enviamos material del curso al siguiente correo ✉️ ' + email;
                    url += '\n\nSi no se encuentra en tu bandeja de entrada, revisar en correo no deseado o spam, luego marcar como ✅ *seguro*';

                    url = encodeURI(url);
                    window.open(url, '_blank');
                  }
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                  console.log(response);
                })
              }

              $( '#btn-crear-' + id ).text('');
              $( '#btn-crear-' + id ).html( 'Crear' );
              $( '#btn-crear-' + id ).attr('disabled', false);
            }
          })
          .fail(function(jqXHR, textStatus, errorThrown) {
            console.log(response);
            alert(response['message']);
            
            $( '#btn-crear-' + id ).text('');
            $( '#btn-crear-' + id ).html( 'Crear' );
            $( '#btn-crear-' + id ).attr('disabled', false);
          })
        });
      });
    </script>
  </body>
</html>