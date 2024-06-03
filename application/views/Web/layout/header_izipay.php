<style>
    .kr-embedded .kr-payment-button {
        color: #ffffff !important;
        background-color: #00A09D !important;
    }

    .kr-embedded .kr-payment-button:hover {
        color: #ffffff !important;
        background-color: #3DD2CE !important;
    }

    .kr-popin-modal-header-background-image{
        background-color: white !important;
    }

    .kr-popin-modal-header {
        border: 0 !important;
    }
    
    .kr-popin-open {
        background-color: white !important;
        visibility: visible;
    }
</style>

<!-- Javascript library. Should be loaded in head section -->
<!--En la etiqueta kr-post-url-success Colocar el archivo de redireccion o URL (RECORDAR)-->
<script 
src="<?php echo $client->getClientEndpoint();?>/static/js/krypton-client/V4.0/stable/kr-payment-form.min.js"
kr-public-key="<?php echo $client->getPublicKey();?>"
kr-post-url-success="<?php echo base_url() . 'Curso/respuestaIzipay'; ?>">
</script>

<!-- theme and plugins. should be loaded after the javascript library -->
<!-- not mandatory but helps to have a nice payment form out of the box -->
<link rel="stylesheet" href="<?php echo $client->getClientEndpoint();?>/static/js/krypton-client/V4.0/ext/classic-reset.css">
<script src="<?php echo $client->getClientEndpoint();?>/static/js/krypton-client/V4.0/ext/classic.js"></script>
