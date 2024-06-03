<html lang="en">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />

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
		</style>

		<script 
		src="<?php echo $client->getClientEndpoint();?>/static/js/krypton-client/V4.0/stable/kr-payment-form.min.js" 
		kr-public-key="<?php echo $client->getPublicKey();?>" 
		kr-post-url-success="<?php echo base_url() . 'Curso/respuestaIzipay'; ?>">
		</script>
		
		<link rel="stylesheet" href="<?php echo $client->getClientEndpoint();?>/static/js/krypton-client/V4.0/ext/classic.css">
		<script src="<?php echo $client->getClientEndpoint();?>/static/js/krypton-client/V4.0/ext/classic.js"></script>
  	</head>
	<body class="bg-light">
		<main>
  			<!-- payment form -->
			<div class="kr-embedded" kr-popin kr-form-token="<?php echo $formToken;?>">
				<!-- payment form fields -->
				<div class="kr-pan"></div>
				<div class="kr-expiry"></div>
				<div class="kr-security-code"></div>

				<!-- payment form submit button -->
				<button class="kr-payment-button"></button>

				<!-- error zone -->
				<div class="kr-form-error"></div>
			</div>
		</main>
	</body>
</html>
