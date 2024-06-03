$(document).ready(function () {
  $('#div-otros_red_social').hide();
  $('input[type=radio][name=radioRedSocial]').change(function() {
    $('#div-otros_red_social').hide();
    if (this.value == '8') {
      $('#div-otros_red_social').show();
      //alert('otros');
    }
});

  const iSetinitialCountry = "pe";
  $("#celular_v2").intlTelInput({
    initialCountry: iSetinitialCountry,
    separateDialCode: true,
    //onlyCountries: ["pe", "mx", "ar", "ec", "ve", "cl", "br", "bo", "co", "py", "py", "uy", "pa", "sv", "hn", "ni", "cr", "cu", "pr", "gt"],
  });

  $('.div-ubigeo_peru').hide();

  $('.input-number').on('input', function () {
    this.value = this.value.replace(/[^0-9]/g, '');
  });

  $( '.input-number_letter' ).on('input', function () {
    this.value = this.value.replace(/[^a-zA-Z0-9]/g,'');
  });

  // $("#email").blur(function () {
  //   checkEmail($(this).val());
  // })

  $("#cbo-pais").select2({
    placeholder: '- Elegir -',
    allowClear: true
  });

  $("#cbo-departamento").select2({
    placeholder: '- Elegir -',
    allowClear: true
  });

  $("#cbo-provincia").select2({
    placeholder: '- Elegir -',
    allowClear: true
  });

  $("#cbo-distrito").select2({
    placeholder: '- Elegir -',
    allowClear: true
  });

  $("#form-registro").on('submit',function(e){
    e.preventDefault();

    //alert($('#cbo-tipo_documento_identidad').val());//null
    //alert($('input[name="radioRedSocial"]:checked').val());
    //alert($('#formTokenv2').val());
    //$(".kr-popin-button").click();
    //KR.setFormConfig({formToken: $('#formTokenv2').val()});

    var email = $('#email'), celular = $('#celular_v2'), dni = $('#dni'), name = $('#name'), edad = $('#edad');

    var instanceCodeCountry = $("[name=celular_v2]");
    instanceCodeCountry.intlTelInput();
    var iCodeCountry = instanceCodeCountry.intlTelInput('getSelectedCountryData').dialCode;
    $('#codigo_pais').val(iCodeCountry);

    $('.help-block').empty();
    $('.form-group').removeClass('has-error');

    //alert( $('#btn-crear_cuenta').data("tipo_token") );
    //alert( $('#' + $('#btn-crear_cuenta').data("tipo_token")).val() );

    if (email.val().length === 0) {
      email.focus();
      email.closest('.form-group').find('.help-block').html('Ingresar email');
      email.closest('.form-group').removeClass('text-success').addClass('text-danger');
    } else if (!checkEmail(email.val())) {
      email.focus();
      email.closest('.form-group').find('.help-block').html('Email inválido');
      email.closest('.form-group').addClass('text-success').removeClass('text-danger');
    } else if (celular.val().length < 8) {
      celular.focus();
      celular.closest('.form-group').find('.help-block').html('Ingresar celular');
      celular.closest('.form-group').removeClass('text-success').addClass('text-danger');
    } else if ($('#cbo-tipo_documento_identidad').val() == null || $('#cbo-tipo_documento_identidad').val()=='') {
      $('#cbo-tipo_documento_identidad').focus();
      $('#cbo-tipo_documento_identidad').closest('.form-group').find('.help-block').html('Seleccionar');
      $('#cbo-tipo_documento_identidad').closest('.form-group').removeClass('text-success').addClass('text-danger');
    } else if (dni.val().length === 0) {
      dni.focus();
      dni.closest('.form-group').find('.help-block').html('Ingresar documento');
      dni.closest('.form-group').removeClass('text-success').addClass('text-danger');
    } else if (name.val().length === 0) {
      name.focus();
      name.closest('.form-group').find('.help-block').html('Ingresar nombres');
      name.closest('.form-group').removeClass('text-success').addClass('text-danger');
    } else if ($('input[name="radioSexo"]:checked').val() === undefined ) {
      $('input[name="radioSexo"]').focus();
      $('input[name="radioSexo"]').closest('.form-group').find('.help-block').html('Elegir sexo');
      $('input[name="radioSexo"]').closest('.form-group').removeClass('text-success').addClass('text-danger');
    } else if ($('input[name="radioRedSocial"]:checked').val() === undefined ) {
      $('input[name="radioRedSocial"]').focus();
      $('input[name="radioRedSocial"]').closest('.form-group').find('.help-block').html('Elegir Red Social');
      $('input[name="radioRedSocial"]').closest('.form-group').removeClass('text-success').addClass('text-danger');
    } else if ($('input[name="radioRedSocial"]:checked').val() == 8 &&  $('#otros_red_social').val().length === 0 ) {
      $('#otros_red_social').focus();
      $('#otros_red_social').closest('.form-group').find('.help-block').html('Ingresar dato');
      $('#otros_red_social').closest('.form-group').removeClass('text-success').addClass('text-danger');
    } else if ($('#cbo-pais').val() == 0) {
      $('#cbo-pais').focus();
      $('#cbo-pais').closest('.form-group').find('.help-block').html('Seleccionar');
      $('#cbo-pais').closest('.form-group').removeClass('text-success').addClass('text-danger');
    } else if ($('#cbo-pais').val() == 1 && $('#cbo-departamento').val()==0) {
      $('#cbo-departamento').focus();
      $('#cbo-departamento').closest('.form-group').find('.help-block').html('Seleccionar País');
      $('#cbo-departamento').closest('.form-group').removeClass('text-success').addClass('text-danger');
    } else if ($('#cbo-pais').val() == 1 && $('#cbo-provincia').val()==0) {
      $('#cbo-provincia').focus();
      $('#cbo-provincia').closest('.form-group').find('.help-block').html('Seleccionar');
      $('#cbo-provincia').closest('.form-group').removeClass('text-success').addClass('text-danger');
    } else if ($('#cbo-pais').val() == 1 && $('#cbo-distrito').val()==0) {
      $('#cbo-distrito').focus();
      $('#cbo-distrito').closest('.form-group').find('.help-block').html('Seleccionar');
      $('#cbo-distrito').closest('.form-group').removeClass('text-success').addClass('text-danger');
    } else {
      $('#btn-crear_cuenta').prop('disabled', true);
      $('#btn-crear_cuenta').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Creando');

      $.ajax({
        url: base_url + 'Curso/crearUsuario',
        type: "POST",
        dataType: "JSON",
        data: $('#form-registro').serialize(),
      })
      .done(function(response) {
        $('#btn-crear_cuenta').prop('disabled', false);
        $('#btn-crear_cuenta').html('Crear cuenta');

        if(response.status=='success') {
          $(".kr-popin-button").click();
          
          $('#id_pedido_curso').val(response.result.id);
          $('#hidden_email').val(response.result.email);
          $('#hidden_password').val(response.result.password);
          $('#hidden_name').val(response.result.name);

          let config = {
            "merchant": {
              "header": {
                "image": {
                  "type": "logo",
                  "visibility": true,
                  "src": base_url + "/assets/img/probusiness_isotipo.jpeg"
                }
              }
            }
          };
          
          KR.setFormConfig(config);
          KR.setFormConfig({formToken: $('#' + $('#btn-crear_cuenta').data("tipo_token")).val() });
        } else {
          $('#modal-message').modal('show');
          $('#modal-title').html(response.message);
        }

      });
    }
  });

  $(document).on('change', '#cbo-pais', function () {
    var id = $(this).val(), sTextoPais = $("#cbo-pais option:selected").text(), response = '';
    $('#cbo-departamento').html('<option value="0" selected="selected">- Cargando -</option>');
    $('.div-ubigeo_peru').hide();
    if (id > 0) {
      if(id==1){//1=peru
        $('.div-ubigeo_peru').show();
      }

      $.post(base_url + 'Curso/searchForIdDepartamento', { ID_Pais : id }, function (response) {
        //console.log(response);
        if(response.status=='success'){
          $('#cbo-departamento').html('<option value="0" selected="selected">- Seleccionar -</option>');
          response = response.result;
          for (var i = 0; i < response.length; i++){
            $('#cbo-departamento').append('<option value="' + response[i].ID_Departamento + '">' + response[i].No_Departamento + '</option>');
          }
        } else {
          $('#cbo-departamento').html('<option value="0" selected="selected">- Sin provincia -</option>');

          alert(response.message);
        }
      }, 'JSON');
    }
  });

  $(document).on('change', '#cbo-departamento', function () {
    var id = $(this).val(), sTextoDepartamento = $("#cbo-departamento option:selected").text(), response = '';
    $('#cbo-provincia').html('<option value="0" selected="selected">- Cargando -</option>');
    if (id > 0) {
      $.post(base_url + 'Curso/searchForIdProvincia', { ID_Departamento: id }, function (response) {
        //console.log(response);
        if(response.status=='success'){
          $('#cbo-provincia').html('<option value="0" selected="selected">- Seleccionar -</option>');
          response = response.result;
          for (var i = 0; i < response.length; i++){
            $('#cbo-provincia').append('<option value="' + response[i].ID_Provincia + '">' + response[i].No_Provincia + '</option>');
          }
        } else {
          $('#cbo-provincia').html('<option value="0" selected="selected">- Sin provincia -</option>');

          alert(response.message);
        }
      }, 'JSON');
    }
  });

  //Direccion modal usuario primera vez
  $(document).on('change', '#cbo-provincia', function () {
    var id = $(this).val(), response = '';
    $('#cbo-distrito').html('<option value="0" selected="selected">- Cargando -</option>');
    if (id > 0) {
      $.post(base_url + 'Curso/searchForIdDistrito', { ID_Provincia: id }, function (response) {
        //console.log(response);
        if(response.status=='success'){
          $('#cbo-distrito').html('<option value="0" selected="selected">- Seleccionar -</option>');
          response = response.result;
          for (var i = 0; i < response.length; i++){
            $('#cbo-distrito').append('<option value="' + response[i].ID_Distrito + '">' + response[i].No_Distrito + '</option>');
          }
        } else {
          $('#cbo-distrito').html('<option value="0" selected="selected">- Sin distrito -</option>');

          alert(response.message);
        }
      }, 'JSON');
    }
  });
});

function checkEmail(email) {
	var caract = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);
	if (caract.test(email) == false) {
		$('#email').closest('.form-group').find('.help-block').html('Email inválido');
    $('#email').closest('.form-group').addClass('text-danger').removeClass('text-success');
		return false;
	} else {
		$('#email').closest('.form-group').find('.help-block').html('Email válido');
    $('#email').closest('.form-group').removeClass('text-danger').addClass('text-success');
    $('#email').closest('.form-group').find('.help-block').removeClass('text-danger');
		return true;
	}
}

var iMinutoConfiguradoBD = '60';
iMinutoConfiguradoBD = ((iMinutoConfiguradoBD=='' || iMinutoConfiguradoBD==null) ? 30 : parseInt(iMinutoConfiguradoBD));
console.log('minutos: ' + iMinutoConfiguradoBD);

var fechaActualContador = new Date();
//var sumarsesion = 30;
var minutes = fechaActualContador.getMinutes();
fechaActualContador.setMinutes(minutes + iMinutoConfiguradoBD);

var end = fechaActualContador;
//var end = new Date('10/05/2023 01:00 PM');

var _second = 1000;
var _minute = _second * 60;
var _hour = _minute * 60;
var _day = _hour * 24;
var timer;
var sInformacionContadorTiempo = '';

function showRemaining() {
  var now = new Date();
  var distance = end - now;
  
  if (distance < 0) {
    //var sumarsesion = 30;
    var minutes = end.getMinutes();
    end.setMinutes(minutes + iMinutoConfiguradoBD);
    //clearInterval(timer);
    //$('.countdown').html('');
    return;
  }

  var days = Math.floor(distance / _day);
  var hours = Math.floor((distance % _day) / _hour);
  var minutes = Math.floor((distance % _hour) / _minute);
  var seconds = Math.floor((distance % _minute) / _second);
  
  sInformacionContadorTiempo = '';

  if(days>0){
    sInformacionContadorTiempo = '<strong>' + days + 'dia' + (days>1 ? 's, ' : ', ') + '</strong>';
  }
  if(hours>0){
    sInformacionContadorTiempo += '<strong>' + hours + ' hora' + (hours>1 ? 's, ' : ', ') + '</strong>';
  }
  if(minutes>0){
    sInformacionContadorTiempo += '<strong>' + minutes + ' minuto'  + (minutes>1 ? 's y ' : 'y ') + '</strong>';
  }
  sInformacionContadorTiempo += '<strong>' + seconds + ' segundos</strong>';

  $('.countdown').html(sInformacionContadorTiempo);
}

timer = setInterval(showRemaining, 1000);