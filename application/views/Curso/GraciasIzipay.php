<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="Geancarlos collazos, escala tu startup y automatiza tú negocio">
		<meta name="generator" content="">
		
		<link rel="shortcut icon" href="<?php echo base_url("assets/images/favicon/favicon.ico?ver=5.0"); ?>">
		<link rel="apple-touch-icon-precomposed" sizes="192x192" href="<?php echo base_url("assets/images/favicon/android-chrome-512x512.png?ver=5.0"); ?>">
		<link rel="apple-touch-icon-precomposed" sizes="192x192" href="<?php echo base_url("assets/images/favicon/android-chrome-192x192.png?ver=5.0"); ?>">
		<link rel="apple-touch-icon-precomposed" sizes="32x32" href="<?php echo base_url("assets/images/favicon/favicon-32x32.png?ver=5.0"); ?>">
		<link rel="apple-touch-icon-precomposed" sizes="16x16" href="<?php echo base_url("assets/images/favicon/favicon-16x16.png?ver=5.0"); ?>">
		<link rel="apple-touch-icon-precomposed" sizes="16x16" href="<?php echo base_url("assets/images/favicon/apple-touch-icon.png?ver=5.0"); ?>">
		<link rel="shortcut icon" href="<?php echo base_url("assets/images/favicon/favicon.png?ver=5.0.0"); ?>" type="image/png">
	  	<link rel="icon" href="<?php echo base_url("assets/images/favicon/favicon.png?ver=5.0.0"); ?>" type="image/png">
		
		<title>ProBusiness | Curso de Importación</title>

		<!-- Google Font: Source Sans Pro -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

		<link rel="stylesheet" href="<?php echo base_url("assets/css/style_curso_registro.css?ver=6.0.0"); ?>">

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/css/intlTelInput.css">

		<meta name="theme-color" content="#FF6700">
		<meta name="msapplication-navbutton-color" content="#FF6700"/>
		<meta name="apple-mobile-web-app-capable" content="yes"/>
		<meta name="msapplication-navbutton-color" content="#FF6700" />
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  	</head>
	<body class="bg-light">
		<main>
			<?php //array_debug($response_izipay); ?>
			<br><br>
			<div class="container mt-5">
				<?php if($response_izipay['status']=='success') { ?>
					<h2 class="text-center mb-4 pt-3 text-success"><i class="fa-solid fa-circle-check fa-3x text-green"></i></h2>
					<h2 class="text-center mb-4"><?php echo $response_izipay['message']; ?></h2>
				<?php } else { ?>
					<h2 class="text-center mb-4 pt-3 text-danger"><i class="fa-solid fa-circle-exclamation fa-3x text-danger"></i></i></h2>
					<h2 class="text-center mb-4"><?php echo $response_izipay['message']; ?></h2>
				<?php } ?>
			</div>
		</main>

		<div class="container py-3 pb-3">
			<footer class="pt-4 my-md-5 pt-md-5 pb-5 border-top">
				<div class="row">
					<div class="col-12 col-md">
						<img class="mb-2" src="<?php echo base_url("assets/images/logo_probusiness.png?ver=5.0.0"); ?>" alt="" height="60">
						<small class="d-block mb-3 text-body-secondary">© 2017 – <?php echo date('Y'); ?></small>
					</div>
					<div class="col-6 col-md">
						<h5 class="fw-bold mb-4">Empresa</h5>
						<ul class="list-unstyled text-small">
						<li class="mb-3"><a class="link-secondary text-decoration-none" href="#">Nosotros</a></li>
						<li class="mb-3"><a class="link-secondary text-decoration-none" href="#">Política de Privacidad</a></li>
						<li class="mb-3"><a class="link-secondary text-decoration-none" href=""terminos">Términos y condiciones</a></li>
						</ul>
					</div>
					<div class="col-6 col-md">
						<h5 class="fw-bold mb-4">Redes Sociales</h5>
						<ul class="list-unstyled text-small">
						<li class="mb-3"><a class="link-secondary text-decoration-none" href="https://www.tiktok.com/@pro_business_impo" alt="ProBusiness" title="ProBusiness" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-tiktok"></i> Tiktok</a></li>
						<li class="mb-3"><a class="link-secondary text-decoration-none" href="https://www.instagram.com/probusinesspe/" alt="ProBusiness" title="ProBusiness" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-instagram"></i> Instagram</a></li>
						<li class="mb-3"><a class="link-secondary text-decoration-none" href="https://www.facebook.com/Probusinesspe" alt="ProBusiness" title="ProBusiness" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-facebook"></i> Facebook</a></li>
						<li class="mb-3"><a class="link-secondary text-decoration-none" href="https://www.youtube.com/@MiguelVillegasImportaciones" alt="ProBusiness" title="ProBusiness" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-youtube"></i> Youtube</a></li>
						</ul>
					</div>
					<div class="col-12 col-md">
						<h5 class="fw-bold mb-4">Contacto</h5>
						<ul class="list-unstyled text-small">
						<li class="mb-3"><a class="link-secondary text-decoration-none" href="tel:+51932531441" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-phone"></i> (+51) 932 531 441</a></li>
						<li class="mb-3"><a class="link-secondary text-decoration-none" href="mailto:info@probusiness.pe" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-envelope"></i> info@probusiness.pe</a></li>
						<li class="mb-3"><a class="link-secondary text-decoration-none" href="https://maps.app.goo.gl/mVnw7c1xdwsSciSx5" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-map-pin"></i> Alberto Barton 527 - La Victoria - Perú</a></li>
						</ul>
					</div>
				</div>
			</footer>
		</div>
	</body>

	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/b7119ee4cd.js" crossorigin="anonymous"></script>
  </body>
</html>
