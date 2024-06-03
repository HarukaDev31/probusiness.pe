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

    <title>Descargar material | Curso de Importación</title>
  </head>
  <body>
    <section class="py-5 text-center container">
        <div class="row py-lg-1">
            <div class="col-md-12 mx-auto">
            <h1 class="text-center mb-4">Descargar material</h1>
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="exampleInputEmail1" class="form-label">Usuario</label>
                            <input type="email" class="form-control" id="username" placeholder="Ingresar">
                        </div>

                        <div class="col-md-6">
                            <label for="exampleInputPassword1" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password">
                        </div>

                        <div class="col-md-12">
                            <!--<label for="exampleInputEmail1" class="form-label">&nbsp;</label>-->
                            <br>
                            <button type="button" id="btn-descargar_material" class="btn btn-block btn-primary" style="width:100%">Descargar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    
    <script>
      $(document).ready(function() {
        $( '#btn-descargar_material' ).click(function(e){
          e.preventDefault();

            var username = $('#username').val();
            var password = $('#password').val();

            if(username.length === 0 ) {
                alert('Ingresar usuario');
            }else if(password.length === 0 ) {
                alert('Ingresar password');
            } else {

                $( '#btn-descargar_material' ).text('');
                $( '#btn-descargar_material' ).attr('disabled', true);
                $( '#btn-descargar_material' ).html( '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>' );

                var arrParams = {
                    evento: 'buscar_usuario',
                    username: username,
                    password: password
                };

                $.ajax({
                    type : 'POST',
                    dataType : 'JSON',
                    url : '../version_1/MoodleRestPro.php',
                    data : arrParams,
                    success : function( response ){
                    console.log(response);
                    
                    if(response['status']=='success'){
                        url = 'descargar_material.php';
                        window.open(url, '_blank');
                    } else {
                      alert(response['message']);
                    }

                    $( '#btn-descargar_material' ).text('');
                    $( '#btn-descargar_material' ).html( 'Descargar' );
                    $( '#btn-descargar_material' ).attr('disabled', false);
                    }
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                    console.log(response);
                    alert(response['message']);
                    
                    $( '#btn-descargar_material' ).text('');
                    $( '#btn-descargar_material' ).html( 'Descargar' );
                    $( '#btn-descargar_material' ).attr('disabled', false);
                })
            }
        });
      });
    </script>
  </body>
</html>