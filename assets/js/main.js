$(function () {
    $('.div-alert').hide();
    $('.div-pago_curso').hide();

    // Validate input
    $('.input-number').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $('.input-letter').on('input', function () {
        this.value = this.value.replace(/[^a-zA-Z ]/g, '');
    });

    $("#email").blur(function () {
        checkEmail($(this).val());
    })

    // Get the form.
    var form = $('#contact-form');

    // Get the messages div.
    var formMessages = $('.alert-message');

    // Set up an event listener for the contact form.
    $('#btn-contact').click(function (e) {
        // Stop the browser from submitting the form.
        e.preventDefault();

        var nombres = $('#firstname'), lastname = $('#lastname'), celular = $('#celular'), email = $('#email'),
        servicios=$('#select-servicios');
        $('.help-block').empty();
        let isValid = true;
        if (nombres.val().length ==0) {
            nombres.focus();
            nombres.closest('.form-group').find('.help-block').html('Ingresar nombre');
            nombres.closest('.form-group').removeClass('text-success').addClass('text-danger');
            isValid = false;
        
        } if (lastname.val().length ==0) {
            lastname.focus();
            lastname.closest('.form-group').find('.help-block').html('Ingresar apellido');
            lastname.closest('.form-group').removeClass('text-success').addClass('text-danger');
            isValid = false;
        
        }  if (celular.val().length === 0) {
            celular.focus();
            celular.closest('.form-group').find('.help-block').html('Ingresar celular');
            celular.closest('.form-group').removeClass('text-success').addClass('text-danger');
            isValid = false;
        
        }  if (celular.val().length < 9) {
            celular.focus();
            celular.closest('.form-group').find('.help-block').html('Ingresar 9 dígitos');
            celular.closest('.form-group').removeClass('text-success').addClass('text-danger');
            isValid = false;
        
        }  if (email.val().length === 0) {
            email.focus();
            email.closest('.form-group').find('.help-block').html('Ingresar email');
            email.closest('.form-group').removeClass('text-success').addClass('text-danger');
            isValid = false;
        
        }  if (!checkEmail(email.val())) {
            email.focus();
            email.closest('.form-group').find('.help-block').html('Email inválido');
            email.closest('.form-group').addClass('text-success').removeClass('text-danger');
            isValid = false;
        
        } if(servicios.length!=0 && servicios.val() == null){
            servicios.focus();
            servicios.closest('.form-group').find('.help-block').html('Seleccionar servicio');
            servicios.closest('.form-group').removeClass('text-success').addClass('text-danger');
            isValid = false;
        
            
        }if(isValid==true){
            $('.help-block').empty();

            $('#btn-contact').text('');
            $('#btn-contact').attr('disabled', true);
            $('#btn-contact').append('Enviando <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

            // Serialize the form data.
            var formData = $(form).serialize();
            console.log(formData);  
            // Submit the form using AJAX.
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: base_url + 'sendwhatsapp',
                data: formData
            })
            .done(function (response) {
                $('.div-alert').show();
                // Make sure that the formMessages div has the 'success' class.
                $(formMessages).removeClass('alert-danger');
                $(formMessages).addClass('alert-primary');

                $('#btn-contact').text('');
                $('#btn-contact').attr('disabled', false);
                $('#btn-contact').append('Enviar mensaje');

                $(formMessages).html(response.message);

                // Clear the form.
                if (response.status == 'success') {
                    //$('#contact-form input, #contact-form email, #contact-form tel,#contact-form textarea').val('');

                    url = 'https://wa.me/' + $('#web_whatsapp').val() + '?text=';
                    url += response.message_whastapp;

                    url = encodeURI(url);
                    window.open(url, '_blank');
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                // show alert area and mark as error
                $('.div-alert').show();
                $(formMessages).removeClass('alert-primary').addClass('alert-danger');

                // restore button
                $('#btn-contact').text('');
                $('#btn-contact').attr('disabled', false);
                $('#btn-contact').append('Enviar mensaje');

                // Log detailed error to console for debugging
                console.error('AJAX error', textStatus, errorThrown, jqXHR);

                // Try to extract a useful message from the response
                var serverMsg = '';
                if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                    serverMsg = jqXHR.responseJSON.message;
                } else if (jqXHR.responseText) {
                    try {
                        var parsed = JSON.parse(jqXHR.responseText);
                        if (parsed.message) serverMsg = parsed.message;
                        else serverMsg = jqXHR.responseText.substring(0, 1000);
                    } catch (e) {
                        serverMsg = jqXHR.responseText.substring(0, 1000);
                    }
                } else {
                    serverMsg = 'Oops! ocurrió un problema. (' + textStatus + (errorThrown ? ' - ' + errorThrown : '') + ')';
                }

                // Show a helpful message in the UI (keep it safe/short)
                $(formMessages).html(serverMsg + '<br><small>Status: ' + jqXHR.status + ' - ' + textStatus + '</small>');
            });
        }
    });
    
    // Set up an event listener for the contact form.
    $('#btn-contact_email').click(function (e) {
        // Stop the browser from submitting the form.
        e.preventDefault();

        var nombres = $('#firstname'), lastname = $('#lastname'), celular = $('#celular'), email = $('#email'),servicios=$('#select-servicios');;
        let isValid = true;
        $('.help-block').empty();
        if (nombres.val().length ==0) {
            nombres.focus();
            nombres.closest('.form-group').find('.help-block').html('Ingresar nombre');
            nombres.closest('.form-group').removeClass('text-success').addClass('text-danger');
            isValid = false;
        } if (lastname.val().length ==0) {
            lastname.focus();
            lastname.closest('.form-group').find('.help-block').html('Ingresar apellido');
            lastname.closest('.form-group').removeClass('text-success').addClass('text-danger');
            isValid = false;

        }  if (celular.val().length === 0) {
            celular.focus();
            celular.closest('.form-group').find('.help-block').html('Ingresar celular');
            celular.closest('.form-group').removeClass('text-success').addClass('text-danger');
            isValid = false;

        }  if (celular.val().length < 9) {
            celular.focus();
            celular.closest('.form-group').find('.help-block').html('Ingresar 9 dígitos');
            celular.closest('.form-group').removeClass('text-success').addClass('text-danger');
            isValid = false;

        }  if (email.val().length === 0) {
            email.focus();
            email.closest('.form-group').find('.help-block').html('Ingresar email');
            email.closest('.form-group').removeClass('text-success').addClass('text-danger');
            isValid = false;

        }  if (!checkEmail(email.val())) {
            email.focus();
            email.closest('.form-group').find('.help-block').html('Email inválido');
            email.closest('.form-group').addClass('text-success').removeClass('text-danger');
            isValid = false;

        }if(servicios.length!=0 && servicios.val() == null){
            servicios.focus();
            servicios.closest('.form-group').find('.help-block').html('Seleccionar servicio');
            servicios.closest('.form-group').removeClass('text-success').addClass('text-danger');
            isValid = false;
        
            
        } if(isValid==true) {
            $('.help-block').empty();

            $('#btn-contact_email').text('');
            $('#btn-contact_email').attr('disabled', true);
            $('#btn-contact_email').append('Enviando <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

            // Serialize the form data.
            var formData = $(form).serialize();

            // Submit the form using AJAX.
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: base_url + 'sendwhatsapp',
                data: formData
            })
            .done(function (response) {
                $('.div-alert').show();
                // Make sure that the formMessages div has the 'success' class.
                $(formMessages).removeClass('alert-danger');
                $(formMessages).addClass('alert-primary');

                $('#btn-contact_email').text('');
                $('#btn-contact_email').attr('disabled', false);
                $('#btn-contact_email').append('Enviar mensaje');

                $(formMessages).html(response.message);
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                $('.div-alert').show();
                $(formMessages).removeClass('alert-primary').addClass('alert-danger');

                $('#btn-contact_email').text('');
                $('#btn-contact_email').attr('disabled', false);
                $('#btn-contact_email').append('Enviar mensaje');

                console.error('AJAX error', textStatus, errorThrown, jqXHR);

                var serverMsg = '';
                if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                    serverMsg = jqXHR.responseJSON.message;
                } else if (jqXHR.responseText) {
                    try {
                        var parsed = JSON.parse(jqXHR.responseText);
                        if (parsed.message) serverMsg = parsed.message;
                        else serverMsg = jqXHR.responseText.substring(0, 1000);
                    } catch (e) {
                        serverMsg = jqXHR.responseText.substring(0, 1000);
                    }
                } else {
                    serverMsg = 'Oops! ocurrió un problema. (' + textStatus + (errorThrown ? ' - ' + errorThrown : '') + ')';
                }

                $(formMessages).html(serverMsg + '<br><small>Status: ' + jqXHR.status + ' - ' + textStatus + '</small>');
            });
        }
    });
});

function checkEmail(email) {
	var caract = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);
	if (caract.test(email) == false) {
		$('#txt-email').closest('.form-group').find('.help-block').html('Email inválido');
        $('#txt-email').closest('.form-group').addClass('text-danger').removeClass('text-success');
		return false;
	} else {
		$('#txt-email').closest('.form-group').find('.help-block').html('Email válido');
        $('#txt-email').closest('.form-group').removeClass('text-danger').addClass('text-success');
        $('#txt-email').closest('.form-group').find('.help-block').removeClass('text-danger');
		return true;
	}
}

function pagar(iTipoPago){
    $('.div-pago_curso').css('display', '').hide().fadeIn(400);

    if(iTipoPago==1){
        $('#btn-crear_cuenta').data('tipo_token','formToken');
        $('#btn-crear_cuenta').attr('data-tipo_token', 'formToken');
    } else if(iTipoPago==2){
        $('#btn-crear_cuenta').data('tipo_token','formTokenv2');
        $('#btn-crear_cuenta').attr('data-tipo_token', 'formTokenv2');
    } else if(iTipoPago==3){
        $('#btn-crear_cuenta').data('tipo_token','formTokenv3');
        $('#btn-crear_cuenta').attr('data-tipo_token', 'formTokenv3');
    }

    var plan = (window.__planesData && window.__planesData[iTipoPago]) || null;
    if ($('#plan_tipo_pago').length) {
        $('#plan_tipo_pago').val(iTipoPago);
    }
    if ($('#plan_price_amount').length) {
        $('#plan_price_amount').val(plan && plan.price_amount != null && plan.price_amount !== '' ? plan.price_amount : '');
    }
    if (plan) {
        $('#plan-elegido-nombre').text(plan.title);
        $('#plan-elegido-precio').text(plan.price_current);
        $('#plan-elegido-badge').fadeIn(300);
    } else {
        $('#plan-elegido-badge').hide();
    }

    setTimeout(function() {
        var el = document.querySelector('.div-pago_curso');
        if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
        if ($('#emailform').length) $('#emailform').focus();
    }, 500);
}