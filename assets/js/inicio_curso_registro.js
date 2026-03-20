$(document).ready(function () {

  /** Iframe grande típico del checkout Izipay / Krypton */
  function cursoIzipayAnyLargeIframe() {
    var iframes = document.querySelectorAll('iframe');
    for (var i = 0; i < iframes.length; i++) {
      try {
        var r = iframes[i].getBoundingClientRect();
        if (r.width > 180 && r.height > 120) return true;
      } catch (e) { /* nothing */ }
    }
    return false;
  }

  /** Modal popin de Krypton (a veces sin iframe hasta cargar) */
  function cursoIzipayPopinSeemsOpen() {
    if (cursoIzipayAnyLargeIframe()) return true;
    var sel = '[class*="kr-popin"], [class*="kr-popin-modal"], .kr-popin-open';
    var nodes = document.querySelectorAll(sel);
    for (var j = 0; j < nodes.length; j++) {
      var el = nodes[j];
      var s = window.getComputedStyle(el);
      if (s.display === 'none' || s.visibility === 'hidden' || s.opacity === '0') continue;
      var r = el.getBoundingClientRect();
      if (r.width > 200 && r.height > 160) return true;
    }
    return false;
  }

  function cursoIzipayStopBackdropWatch() {
    if (window.__izipayBackdropInterval) {
      clearInterval(window.__izipayBackdropInterval);
      window.__izipayBackdropInterval = null;
    }
  }

  /** Mantiene overlay negro mientras el pago está abierto; lo oculta al cerrar el popin */
  function cursoIzipayStartBackdropWatch() {
    cursoIzipayStopBackdropWatch();
    window.__izipaySeenPopin = false;
    window.__izipayBackdropStarted = Date.now();
    window.__izipayBackdropInterval = setInterval(function () {
      if (Date.now() - window.__izipayBackdropStarted > 180000) {
        $('#izipay-loading-overlay').removeClass('izipay-overlay-click-through');
        $('#izipay-loading-overlay').fadeOut(400);
        cursoIzipayStopBackdropWatch();
        return;
      }
      var open = cursoIzipayPopinSeemsOpen();
      if (open) {
        window.__izipaySeenPopin = true;
        $('#izipay-loading-overlay .izipay-loading-panel').stop(true, true).fadeOut(220);
        /* Dejar el velo oscuro visible pero que el iframe/modal de Izipay reciba clics */
        $('#izipay-loading-overlay').addClass('izipay-overlay-click-through');
      }
      if (window.__izipaySeenPopin && !open) {
        $('#izipay-loading-overlay').removeClass('izipay-overlay-click-through');
        $('#izipay-loading-overlay').fadeOut(400);
        cursoIzipayStopBackdropWatch();
        window.__izipaySeenPopin = false;
      }
    }, 400);
  }

  function toggleOtros_red_social() {
    try {
      var val = $('input[name="radioRedSocial"]:checked').val();
      if (val === '6') { $('#div-otros_red_social').show(); }
      else { $('#div-otros_red_social').hide(); }
    } catch (e) { /* nothing */ }
  }
  toggleOtros_red_social();
  setTimeout(toggleOtros_red_social, 50);
  setTimeout(toggleOtros_red_social, 300);
  $(document).on('change', 'input[name="radioRedSocial"]', toggleOtros_red_social);
  $(document).on('click', 'label[for^="radioRedSocial"]', function () { setTimeout(toggleOtros_red_social, 10); });

  var iSetinitialCountry = "pe";
  $("#celular_v2").intlTelInput({
    initialCountry: iSetinitialCountry,
    separateDialCode: true,
  });

  $('.div-ubigeo_peru').hide();
  $('.input-number').on('input', function () { this.value = this.value.replace(/[^0-9]/g, ''); });
  $('.input-number_letter').on('input', function () { this.value = this.value.replace(/[^a-zA-Z0-9]/g, ''); });
  $("#email").blur(function () { checkEmail($(this).val()); });

  $("#cbo-pais").select2({ placeholder: '- Elegir -', allowClear: true });
  $("#cbo-departamento").select2({ placeholder: '- Elegir -', allowClear: true });
  $("#cbo-provincia").select2({ placeholder: '- Elegir -', allowClear: true });
  $("#cbo-distrito").select2({ placeholder: '- Elegir -', allowClear: true });

  $("#form-registro").on('submit', function (e) {
    e.preventDefault();

    var email = $('#emailform'), celular = $('#celular_v2'), dni = $('#dni'), name = $('#name');

    var instanceCodeCountry = $("[name=celular_v2]");
    instanceCodeCountry.intlTelInput();
    var iCodeCountry = instanceCodeCountry.intlTelInput('getSelectedCountryData').dialCode;
    $('#codigo_pais').val(iCodeCountry);

    $('.help-block').empty();
    $('.form-group').removeClass('has-error');

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
    } else if ($('#cbo-tipo_documento_identidad').val() == null || $('#cbo-tipo_documento_identidad').val() == '') {
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
    } else if ($('input[name="radioSexo"]:checked').val() === undefined) {
      $('input[name="radioSexo"]').focus();
      $('input[name="radioSexo"]').closest('.form-group').find('.help-block').html('Elegir sexo');
      $('input[name="radioSexo"]').closest('.form-group').removeClass('text-success').addClass('text-danger');
    } else if ($('input[name="radioRedSocial"]:checked').val() === undefined) {
      $('input[name="radioRedSocial"]').focus();
      $('input[name="radioRedSocial"]').closest('.form-group').find('.help-block').html('Elegir Red Social');
      $('input[name="radioRedSocial"]').closest('.form-group').removeClass('text-success').addClass('text-danger');
    } else if ($('input[name="radioRedSocial"]:checked').val() == 6 && $('#otros_red_social').val().length === 0) {
      $('#otros_red_social').focus();
      $('#otros_red_social').closest('.form-group').find('.help-block').html('Ingresar dato');
      $('#otros_red_social').closest('.form-group').removeClass('text-success').addClass('text-danger');
    } else if ($('#cbo-pais').val() == 0) {
      $('#cbo-pais').focus();
      $('#cbo-pais').closest('.form-group').find('.help-block').html('Seleccionar');
      $('#cbo-pais').closest('.form-group').removeClass('text-success').addClass('text-danger');
    } else if ($('#cbo-pais').val() == 1 && $('#cbo-departamento').val() == 0) {
      $('#cbo-departamento').focus();
      $('#cbo-departamento').closest('.form-group').find('.help-block').html('Seleccionar País');
      $('#cbo-departamento').closest('.form-group').removeClass('text-success').addClass('text-danger');
    } else if ($('#cbo-pais').val() == 1 && $('#cbo-provincia').val() == 0) {
      $('#cbo-provincia').focus();
      $('#cbo-provincia').closest('.form-group').find('.help-block').html('Seleccionar');
      $('#cbo-provincia').closest('.form-group').removeClass('text-success').addClass('text-danger');
    } else if ($('#cbo-pais').val() == 1 && $('#cbo-distrito').val() == 0) {
      $('#cbo-distrito').focus();
      $('#cbo-distrito').closest('.form-group').find('.help-block').html('Seleccionar');
      $('#cbo-distrito').closest('.form-group').removeClass('text-success').addClass('text-danger');
    } else {
      $('#btn-crear_cuenta').prop('disabled', true);
      $('#btn-crear_cuenta').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Creando');
      console.log($('#form-registro').serialize());

      $.ajax({
        url: base_url + 'Curso/crearUsuario',
        type: "POST",
        dataType: "JSON",
        data: $('#form-registro').serialize(),
      })
      .done(function (response) {
        $('#btn-crear_cuenta').prop('disabled', false);
        $('#btn-crear_cuenta').html('Finalizar compra');

        if (!response || typeof response !== 'object') {
          alert('Respuesta inválida del servidor.');
          return;
        }

        if (response.status == 'success') {
          $('#id_pedido_curso').val(response.result.id);
          $('#hidden_email').val(response.result.email);
          $('#hidden_password').val(response.result.password);
          $('#hidden_name').val(response.result.name);

          var tokenKey = $('#btn-crear_cuenta').data("tipo_token");
          if (!tokenKey || tokenKey === '0') tokenKey = 'formToken';
          var tipoPago = tokenKey === 'formTokenv3' ? 3 : tokenKey === 'formTokenv2' ? 2 : 1;
          var plan = (window.__planesData && window.__planesData[tipoPago]) || null;
          var montoTexto = plan ? plan.price_current : '';

          var $overlay = $('#izipay-loading-overlay');
          if ($overlay.length) {
            $('#izipay-loading-monto').text(montoTexto ? 'Monto a pagar: ' + montoTexto : '');
            $overlay.removeClass('izipay-overlay-click-through');
            $overlay.find('.izipay-loading-panel').show();
            $overlay.css({ display: 'flex', opacity: 0 }).animate({ opacity: 1 }, 300);
          }

          var formTokenVal = $('#' + tokenKey).val();
          var fullConfig = {
            formToken: formTokenVal,
            "merchant": {
              "header": {
                "image": {
                  "type": "logo",
                  "visibility": true,
                  "src": base_url + "assets/img/probusiness_isotipo.jpeg"
                }
              }
            }
          };

          var abrirPopin = function () {
            cursoIzipayStartBackdropWatch();
            $(".kr-popin-button").click();
          };

          var p = KR.setFormConfig(fullConfig);
          if (p && typeof p.then === 'function') {
            p.then(function () { abrirPopin(); })
             .catch(function () { abrirPopin(); });
          } else {
            setTimeout(abrirPopin, 300);
          }
        } else {
          $('#modal-message').modal('show');
          $('#modal-title').html(response.message);
        }
      })
      .fail(function (xhr) {
        $('#btn-crear_cuenta').prop('disabled', false);
        $('#btn-crear_cuenta').html('Finalizar compra');
        var msg = '';
        if (xhr.responseJSON && xhr.responseJSON.message) {
          msg = xhr.responseJSON.message;
        } else if (xhr.responseText) {
          try { var parsed = JSON.parse(xhr.responseText); if (parsed && parsed.message) msg = parsed.message; }
          catch (ignore) { /* no JSON */ }
        }
        if (!msg) msg = xhr.status ? ('Error ' + xhr.status + (xhr.statusText ? ': ' + xhr.statusText : '')) : 'Error de red o del servidor.';
        alert(msg);
      });
    }
  });

  $(document).on('change', '#cbo-pais', function () {
    var id = $(this).val();
    $('#cbo-departamento').html('<option value="0" selected="selected">- Cargando -</option>');
    $('#cbo-provincia').html('<option value="0" selected="selected">- Seleccionar -</option>');
    $('#cbo-distrito').html('<option value="0" selected="selected">- Seleccionar -</option>');
    $('.div-ubigeo_peru').hide();
    if (id > 0 && id == 1) {
      $('.div-ubigeo_peru').show();
      fetch(ubicacion_api_base + '/departamentos', { credentials: 'omit', headers: { 'Accept': 'application/json' } })
        .then(function (r) { return r.json(); })
        .then(function (data) {
          $('#cbo-departamento').html('<option value="0" selected="selected">- Seleccionar -</option>');
          if (data.success && data.data) {
            data.data.forEach(function (d) {
              $('#cbo-departamento').append('<option value="' + d.id + '">' + d.nombre + '</option>');
            });
          }
        })
        .catch(function () {
          $('#cbo-departamento').html('<option value="0" selected="selected">- Error al cargar -</option>');
        });
    }
  });

  $(document).on('change', '#cbo-departamento', function () {
    var id = $(this).val();
    $('#cbo-provincia').html('<option value="0" selected="selected">- Cargando -</option>');
    $('#cbo-distrito').html('<option value="0" selected="selected">- Seleccionar -</option>');
    if (id > 0) {
      fetch(ubicacion_api_base + '/provincias/' + id, { credentials: 'omit', headers: { 'Accept': 'application/json' } })
        .then(function (r) { return r.json(); })
        .then(function (data) {
          $('#cbo-provincia').html('<option value="0" selected="selected">- Seleccionar -</option>');
          if (data.success && data.data) {
            data.data.forEach(function (p) {
              $('#cbo-provincia').append('<option value="' + p.id + '">' + p.nombre + '</option>');
            });
          }
        })
        .catch(function () {
          $('#cbo-provincia').html('<option value="0" selected="selected">- Error al cargar -</option>');
        });
    }
  });

  $(document).on('change', '#cbo-provincia', function () {
    var id = $(this).val();
    $('#cbo-distrito').html('<option value="0" selected="selected">- Cargando -</option>');
    if (id > 0) {
      fetch(ubicacion_api_base + '/distritos/' + id, { credentials: 'omit', headers: { 'Accept': 'application/json' } })
        .then(function (r) { return r.json(); })
        .then(function (data) {
          $('#cbo-distrito').html('<option value="0" selected="selected">- Seleccionar -</option>');
          if (data.success && data.data) {
            data.data.forEach(function (d) {
              $('#cbo-distrito').append('<option value="' + d.id + '">' + d.nombre + '</option>');
            });
          }
        })
        .catch(function () {
          $('#cbo-distrito').html('<option value="0" selected="selected">- Error al cargar -</option>');
        });
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
iMinutoConfiguradoBD = ((iMinutoConfiguradoBD == '' || iMinutoConfiguradoBD == null) ? 30 : parseInt(iMinutoConfiguradoBD));
console.log('minutos: ' + iMinutoConfiguradoBD);

var fechaActualContador = new Date();
var minutes = fechaActualContador.getMinutes();
fechaActualContador.setMinutes(minutes + iMinutoConfiguradoBD);
var end = fechaActualContador;

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
    var minutes = end.getMinutes();
    end.setMinutes(minutes + iMinutoConfiguradoBD);
    return;
  }

  var days = Math.floor(distance / _day);
  var hours = Math.floor((distance % _day) / _hour);
  var minutes = Math.floor((distance % _hour) / _minute);
  var seconds = Math.floor((distance % _minute) / _second);

  sInformacionContadorTiempo = '';
  if (days > 0) {
    sInformacionContadorTiempo = '<strong>' + days + 'dia' + (days > 1 ? 's, ' : ', ') + '</strong>';
  }
  if (hours > 0) {
    sInformacionContadorTiempo += '<strong>' + hours + ' hora' + (hours > 1 ? 's, ' : ', ') + '</strong>';
  }
  if (minutes > 0) {
    sInformacionContadorTiempo += '<strong>' + minutes + ' minuto' + (minutes > 1 ? 's y ' : 'y ') + '</strong>';
  }
  sInformacionContadorTiempo += '<strong>' + seconds + ' segundos</strong>';

  $('.countdown').html(sInformacionContadorTiempo);
}

timer = setInterval(showRemaining, 1000);
