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
    <link rel="shortcut icon" href="img/favicon.ico?ver=5.0">
    <link rel="apple-touch-icon-precomposed" sizes="192x192" href="img/android-chrome-512x512.png?ver=5.0">
    <link rel="apple-touch-icon-precomposed" sizes="192x192" href="img/android-chrome-192x192.png?ver=5.0">
    <link rel="apple-touch-icon-precomposed" sizes="32x32" href="img/favicon-32x32.png?ver=5.0">
    <link rel="apple-touch-icon-precomposed" sizes="16x16" href="img/favicon-16x16.png?ver=5.0">
    <link rel="apple-touch-icon-precomposed" sizes="16x16" href="img/apple-touch-icon.png?ver=5.0">
    <link rel="manifest" href="img/site.webmanifest">
    <link rel="shortcut icon" href="img/favicon.png?ver=5.0.0" type="image/png">
	  <link rel="icon" href="img/favicon.png?ver=5.0.0" type="image/png">

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <title>Probusiness | Clientes</title>
    <style>
.div-table-button {
    display: flex;justify-content: space-between;
    }
    .buttons-excel {
      background: #198754;
    }
    </style>

  </head>
  <body>
    <section class="py-5 text-center container">
      <div class="row py-lg-1">
        <div class="col-md-12 mx-auto">
          <h1 class="text-center mb-4">Clientes</h1>
          
          <div class="row">
            <div class="col-md-6 text-start">
              <label for="exampleInputEmail1" class="form-label fw-bold">Email</label>
              <div class="form-group">
                <input type="email" class="form-control" id="email" placeholder="Ingresar">
              </div>
            </div>

            <div class="col-4 col-md-2">
              <label class="form-label">&nbsp;</label>
              <button data-id="0" data-email="" data-firstname="" type="button" id="btn-correo-0" class="btn btn-block btn-primary btn-enviar_correo" style="width:100%">Aérea <i class="bi bi-envelope-fill"></i></button>
            </div>

            <div class="col-4 col-md-2">
              <label class="form-label">&nbsp;</label>
              <button data-id="0" data-email="" data-firstname="" type="button" id="btn-maritima-0" class="btn btn-block btn-primary btn-enviar_correo_maritima" style="width:100%">Marítimo C.C <i class="bi bi-envelope-fill"></i></button>
            </div>

            <div class="col-4 col-md-2">
              <label class="form-label">&nbsp;</label>
              <button data-id="0" data-email="" data-firstname="" type="button" id="btn-btn-maritima_independiente-0" class="btn btn-block btn-primary btn-enviar_correo_maritima_independiente" style="width:100%">Marítimo Indep. <i class="bi bi-envelope-fill"></i></button>
            </div>
          </div>

          <br><br>
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
                <th class="col">Correo Ruta</th>
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
                <!--<th scope="col">Cursos</th>-->
                <!--<th scope="col">Etiqueta</th>-->
              </tr>
            </thead>
            <tbody>
            <?php
            foreach($response['items'] as $row){
              if(isset($row['custom']['cf_en_que_rubro_estas_interesad_bkvd_dropdown'])){
                
                $firstName = trim($row['personal']['firstName']);
                //$email = trim($row['personal']['email']) . '11';
                $email = trim($row['personal']['email']);

                $arrUsername = explode("@", $email);
                $username = $arrUsername[0];
                $password = strtoupper(substr($username,0,1)) . substr($username,1,strlen($username)) . date('Y') . date('m') . '$Pb';
                if (is_numeric($username)) {
                  $password_v2 = $arrUsername[1];
                  $password = strtoupper(substr($password_v2,0,1)) . substr($password_v2,1,strlen($password_v2)) . date('Y') . date('m') . '$Pb';
                }
                
                $arrDate =  explode("T", $row['created']);

                $phoneNumber = $row['personal']['phoneNumber'];

                $sMembresia = (isset($row['custom']['cf_contact_elige_tu_membresia_myus_dropdown']) ? $row['custom']['cf_contact_elige_tu_membresia_myus_dropdown'] : 'Renovación');

                $sEtiqueta = '';
                $iIdEtiqueta = 0;
                
                //"724f8eb0-6f95-11ee-8079-c20120102465","name":"plan_emprendedor"
                //"7da9a4f8-6f95-11ee-88b0-52a8440778fb","name":"plan_empresarial"
                //"78ce53ac-6f95-11ee-bfac-ae897aec92db","name":"plan_premium"

                $posicionCoincidenciaEmprendedor = strpos($sMembresia, "Emprendedor");
                if($posicionCoincidenciaEmprendedor !== false){
                  $sEtiqueta = 'plan_emprendedor';
                  $iIdEtiqueta = '724f8eb0-6f95-11ee-8079-c20120102465';
                }
                
                $posicionCoincidenciaEmpresarial = strpos($sMembresia, "Empresarial");
                if($posicionCoincidenciaEmpresarial !== false){
                  $sEtiqueta = 'plan_empresarial';
                  $iIdEtiqueta = '7da9a4f8-6f95-11ee-88b0-52a8440778fb';
                }
                
                $posicionCoincidenciaPremium = strpos($sMembresia, "Premium");
                if($posicionCoincidenciaPremium !== false){
                  $sEtiqueta = 'plan_premium';
                  $iIdEtiqueta = '78ce53ac-6f95-11ee-bfac-ae897aec92db';
                }

                ?>
                    <tr>
                      <td>
                        <button type="button" id="btn-correo-<?php echo $row['id']; ?>"
                          data-id="<?php echo $row['id']; ?>"
                          data-email="<?php echo $email; ?>"
                          data-firstname="<?php echo $firstName; ?>"
                          class="btn btn-primary btn-enviar_correo" alt="Enviar correo" title="Enviar correo" href="javascript:void(0)">
                          Aérea <i class="bi bi-envelope-fill"></i>
                        </button><br><br>
                        <button type="button" id="btn-maritima-<?php echo $row['id']; ?>"
                          data-id="<?php echo $row['id']; ?>"
                          data-email="<?php echo $email; ?>"
                          data-firstname="<?php echo $firstName; ?>"
                          class="btn btn-primary btn-enviar_correo_maritima" alt="Enviar correo" title="Enviar correo" href="javascript:void(0)">
                          Marítimo C.C <i class="bi bi-envelope-fill"></i>
                        </button><br><br>
                        <button type="button" id="btn-maritima_independiente-<?php echo $row['id']; ?>"
                          data-id="<?php echo $row['id']; ?>"
                          data-email="<?php echo $email; ?>"
                          data-firstname="<?php echo $firstName; ?>"
                          class="btn btn-primary btn-enviar_correo_maritima_independiente" alt="Enviar correo" title="Enviar correo" href="javascript:void(0)">
                          Marítimo Indep. <i class="bi bi-envelope-fill"></i>
                        </button>
                      </td>
                      <td>
                        <button type="button" id="btn-crear-<?php echo $row['id']; ?>"
                          data-id="<?php echo $row['id']; ?>"
                          data-username="<?php echo $username; ?>"
                          data-password="<?php echo $password; ?>"
                          data-firstname="<?php echo $firstName; ?>"
                          data-email="<?php echo $email; ?>"
                          data-phone="<?php echo $phoneNumber; ?>"
                          data-id_etiqueta="<?php echo $iIdEtiqueta; ?>"
                          class="btn btn-secondary btn-crear_usuario" alt="Crear usuario" title="Crear usuario" href="javascript:void(0)">
                          Crear
                        </button>
                        <br><br>
                        <button type="button" id="btn-curso-<?php echo $row['id']; ?>"
                          data-id="<?php echo $row['id']; ?>"
                          data-username="<?php echo $username; ?>"
                          class="btn btn-secondary btn-curso" alt="Asignar cursos" title="Asignar cursos" href="javascript:void(0)">
                          Asignar cursos
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
                      <!--
                      <td>
                        <button type="button" id="btn-curso-<?php echo $row['id']; ?>"
                          data-id="<?php echo $row['id']; ?>"
                          data-username="<?php echo $username; ?>"
                          class="btn btn-secondary btn-curso" alt="Actualizar curso" title="Actualizar curso" href="javascript:void(0)">
                          Agregar
                        </button>
                      </td>
                      -->
                      <!--
                      <td>
                        <?php echo $sEtiqueta; ?>
                        <button type="button" id="btn-etiqueta-<?php echo $row['id']; ?>"
                          data-id="<?php echo $row['id']; ?>"
                          data-id_etiqueta="<?php echo $iIdEtiqueta; ?>"
                          class="btn btn-secondary btn-etiqueta" alt="Actualizar etiqueta" title="Actualizar etiqueta" href="javascript:void(0)">
                          Etiqueta
                        </button>
                      </td>
                      -->
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
          dom: "<'row'<'col-sm-12 col-md-5 div-table-button'B><'col-sm-12 col-md-2'><'col-sm-12 col-md-5'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-5'p>>",
          buttons     : [{
            extend    : 'excel',
            text      : '<i class="fa fa-file-excel color_icon_excel"></i> Excel',
            titleAttr : 'Excel',
            exportOptions: {
              columns: ':visible'
            }
          }],
          'oLanguage' : {
            'sInfo'               : 'Mostrando (_START_ - _END_) total de registros _TOTAL_',
            'sLengthMenu'         : '_MENU_',
            'sSearch'             : '',
            'sSearchPlaceholder'  : 'Buscar...',
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

        $('#example_filter input').removeClass('form-control-sm');
        $('#example_filter input').addClass('form-control-lg');
        //$( '#example_filter > label' ).remove('custom-select-sm form-control-sm');

        $( '.btn-curso' ).click(function(e){
          e.preventDefault();

          var id = $(this).data('id');
          var username = $(this).data('username');

          $( '#btn-curso-' + id ).text('');
          $( '#btn-curso-' + id ).attr('disabled', true);
          $( '#btn-curso-' + id ).html( '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>' );

          var arrParams = {
            evento : 'asignar_curso_usuario',
            id: id,
            username: username
          };

          $.ajax({
            type : 'POST',
            dataType : 'JSON',
            url : 'MoodleRestAgregarCurso.php',
            data : arrParams,
            success : function( response ){
              alert(response['message']);

              $( '#btn-curso-' + id ).text('');
              $( '#btn-curso-' + id ).html( 'Asignar curso' );
              $( '#btn-curso-' + id ).attr('disabled', false);
            }
          })
          .fail(function(jqXHR, textStatus, errorThrown) {
            console.log(response);
            alert(response['message']);
            
            $( '#btn-curso-' + id ).text('');
            $( '#btn-curso-' + id ).html( 'Asignar curso' );
            $( '#btn-curso-' + id ).attr('disabled', false);
          })
        });

        $( '.btn-etiqueta' ).click(function(e){
          e.preventDefault();

          var id = $(this).data('id');
          var id_etiqueta = $(this).data('id_etiqueta');

          $( '#btn-etiqueta-' + id ).text('');
          $( '#btn-etiqueta-' + id ).attr('disabled', true);
          $( '#btn-etiqueta-' + id ).html( '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>' );

          var arrParams = {
            evento : 'actualizar',
            id: id,
            id_etiqueta: id_etiqueta
          };

          $.ajax({
            type : 'POST',
            dataType : 'JSON',
            url : 'api_escala_actualizar_tag.php',
            data : arrParams,
            success : function( response ){
              alert(response['message']);

              $( '#btn-etiqueta-' + id ).text('');
              $( '#btn-etiqueta-' + id ).html( 'Etiqueta' );
              $( '#btn-etiqueta-' + id ).attr('disabled', false);
            }
          })
          .fail(function(jqXHR, textStatus, errorThrown) {
            console.log(response);
            alert(response['message']);
            
            $( '#btn-etiqueta-' + id ).text('');
            $( '#btn-etiqueta-' + id ).html( 'Etiqueta' );
            $( '#btn-etiqueta-' + id ).attr('disabled', false);
          })
        });

        $( '.btn-enviar_correo' ).click(function(e){
          e.preventDefault();

          var id = $(this).data('id');
          if(id!=''){
            var email = $(this).data('email');
            var firstname = $(this).data('firstname');
          } else {
            var email = $('#email').val();
            var firstname = $('#email').val()
          }

          $( '#btn-correo-' + id ).text('');
          $( '#btn-correo-' + id ).attr('disabled', true);
          $( '#btn-correo-' + id ).html( '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>' );

          var arrParams = {
            tipo_correo : 'aerea',
            email: email,
            firstname: firstname
          };

          $.ajax({
            type : 'POST',
            dataType : 'JSON',
            url : '../CorreoRutaAerea',
            data : arrParams,
            success : function( response ){
              console.log(response);
              
              alert(response['message']);

              $( '#btn-correo-' + id ).text('');
              $( '#btn-correo-' + id ).html( 'Aérea <i class="bi bi-envelope-fill"></i>' );
              $( '#btn-correo-' + id ).attr('disabled', false);
            }
          })
          .fail(function(jqXHR, textStatus, errorThrown) {
            console.log(response);
            alert(response['message']);
            
            $( '#btn-correo-' + id ).text('');
            $( '#btn-correo-' + id ).html( 'Aérea <i class="bi bi-envelope-fill"></i>' );
            $( '#btn-correo-' + id ).attr('disabled', false);
          })
        });
        
        $( '.btn-enviar_correo_maritima' ).click(function(e){
          e.preventDefault();

          var id = $(this).data('id');
          if(id!=''){
            var email = $(this).data('email');
            var firstname = $(this).data('firstname');
          } else {
            var email = $('#email').val();
            var firstname = $('#email').val()
          }

          $( '#btn-maritima-' + id ).text('');
          $( '#btn-maritima-' + id ).attr('disabled', true);
          $( '#btn-maritima-' + id ).html( '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>' );

          var arrParams = {
            tipo_correo : 'maritima',
            email: email,
            firstname: firstname
          };

          $.ajax({
            type : 'POST',
            dataType : 'JSON',
            url : '../CorreoRutaAerea',
            data : arrParams,
            success : function( response ){
              console.log(response);
              
              alert(response['message']);

              $( '#btn-maritima-' + id ).text('');
              $( '#btn-maritima-' + id ).html( 'Marítimo C.C <i class="bi bi-envelope-fill"></i>' );
              $( '#btn-maritima-' + id ).attr('disabled', false);
            }
          })
          .fail(function(jqXHR, textStatus, errorThrown) {
            console.log(response);
            alert(response['message']);
            
            $( '#btn-maritima-' + id ).text('');
            $( '#btn-maritima-' + id ).html( 'Marítimo C.C <i class="bi bi-envelope-fill"></i>' );
            $( '#btn-maritima-' + id ).attr('disabled', false);
          })
        });
        
        $( '.btn-enviar_correo_maritima_independiente' ).click(function(e){
          e.preventDefault();

          var id = $(this).data('id');
          if(id!=''){
            var email = $(this).data('email');
            var firstname = $(this).data('firstname');
          } else {
            var email = $('#email').val();
            var firstname = $('#email').val()
          }

          $( '#btn-maritima_independiente-' + id ).text('');
          $( '#btn-maritima_independiente-' + id ).attr('disabled', true);
          $( '#btn-maritima_independiente-' + id ).html( '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>' );

          var arrParams = {
            tipo_correo : 'maritima_independiente',
            email: email,
            firstname: firstname
          };

          $.ajax({
            type : 'POST',
            dataType : 'JSON',
            url : '../CorreoRutaAerea',
            data : arrParams,
            success : function( response ){
              console.log(response);
              
              alert(response['message']);

              $( '#btn-maritima_independiente-' + id ).text('');
              $( '#btn-maritima_independiente-' + id ).html( 'Marítimo Indep. <i class="bi bi-envelope-fill"></i>' );
              $( '#btn-maritima_independiente-' + id ).attr('disabled', false);
            }
          })
          .fail(function(jqXHR, textStatus, errorThrown) {
            console.log(response);
            alert(response['message']);
            
            $( '#btn-maritima_independiente-' + id ).text('');
            $( '#btn-maritima_independiente-' + id ).html( 'Marítimo Indep. <i class="bi bi-envelope-fill"></i>' );
            $( '#btn-maritima_independiente-' + id ).attr('disabled', false);
          })
        });

        $( '.btn-crear_usuario' ).click(function(e){
          e.preventDefault();

          var id = $(this).data('id');
          var username = $(this).data('username');
          var password = $(this).data('password');
          var phone = $(this).data('phone');
          var firstname = $(this).data('firstname');
          var email = $(this).data('email');
          var id_etiqueta = $(this).data('id_etiqueta');

          $( '#btn-crear-' + id ).text('');
          $( '#btn-crear-' + id ).attr('disabled', true);
          $( '#btn-crear-' + id ).html( '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>' );

          var arrParams = {
            evento: 'crear_usuario',
            username: username,
            password: password,
            firstname: firstname,
            email: email,
            id: id,
            id_etiqueta : id_etiqueta
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