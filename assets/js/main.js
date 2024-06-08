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
            .fail(function (data) {
                $('.div-alert').show();
                // Make sure that the formMessages div has the 'error' class.
                $(formMessages).removeClass('alert-primary');
                $(formMessages).addClass('alert-danger');

                $('#btn-contact').text('');
                $('#btn-contact').attr('disabled', false);
                $('#btn-contact').append('Enviar mensaje');

                // Set the message text.
                if (data.responseText !== '') {
                    $(formMessages).text(data.responseText);
                } else {
                    $(formMessages).html('Oops! ocurrió un problema.');
                }
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
            .fail(function (data) {
                $('.div-alert').show();
                // Make sure that the formMessages div has the 'error' class.
                $(formMessages).removeClass('alert-primary');
                $(formMessages).addClass('alert-danger');

                $('#btn-contact_email').text('');
                $('#btn-contact_email').attr('disabled', false);
                $('#btn-contact_email').append('Enviar mensaje');

                // Set the message text.
                if (data.responseText !== '') {
                    $(formMessages).text(data.responseText);
                } else {
                    $(formMessages).html('Oops! ocurrió un problema.');
                }
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
    $('.div-pago_curso').show();
    $('#email').focus();
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
}