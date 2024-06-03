<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="Geancarlos collazos, escala tu startup y automatiza tú negocio">
		<meta name="generator" content="">
		
		<link rel="shortcut icon" href="assets/images/favicon/favicon.ico?ver=5.0">
		<link rel="apple-touch-icon-precomposed" sizes="192x192" href="assets/images/favicon/android-chrome-512x512.png?ver=5.0">
		<link rel="apple-touch-icon-precomposed" sizes="192x192" href="assets/images/favicon/android-chrome-192x192.png?ver=5.0">
		<link rel="apple-touch-icon-precomposed" sizes="32x32" href="assets/images/favicon/favicon-32x32.png?ver=5.0">
		<link rel="apple-touch-icon-precomposed" sizes="16x16" href="assets/images/favicon/favicon-16x16.png?ver=5.0">
		<link rel="apple-touch-icon-precomposed" sizes="16x16" href="assets/images/favicon/apple-touch-icon.png?ver=5.0">
		<link rel="shortcut icon" href="assets/images/favicon/favicon.png?ver=5.0.0" type="image/png">
		<link rel="icon" href="assets/images/favicon/favicon.png?ver=5.0.0" type="image/png">
		
		<title>ProBusiness | Curso de Importación</title>

		<!-- Google Font: Source Sans Pro -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

		<link rel="stylesheet" href="assets/css/style.css?ver=57.0.0">

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
			<div class="container mt-5">
				<div class="row justify-content-center">
					<div class="col-md-6 home-div-card">
						<form id="loginForm">
							<div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-4 text-center">
								<h4 class="modal-title fw-bold" id="">Regístrate</h4>
							</div>

							<div class="row">
								<div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
									<label class="fw-bold mb-2" for="floatEmail">Email</label>
									<input type="email" inputmode="email" class="form-control" id="floatEmail" placeholder="name@example.com">
								</div>
							</div>

							<div class="row">
								<div class="col-12 col-sm-6 col-md-6 col-lg-6 mb-3">
									<label for="floatName" class="fw-bold mb-2" for="floatEmail">Celular</label>
									<input type="text" inputmode="tel" class="form-control w-100" id="txt-celular" placeholder="">
								</div>

								<div class="col-12 col-sm-6 col-md-6 col-lg-6 mb-3">
									<label for="floatName" class="fw-bold mb-2" for="floatEmail">DNI / RUC / OTROS</label>
									<input type="text" class="form-control" id="floatName" placeholder="">
								</div>
							</div>

							<div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
								<label for="floatName" class="fw-bold mb-2" for="floatEmail">Nombres y Apellidos</label>
								<input type="text" class="form-control" id="floatName" placeholder="">
							</div>

							<div class="row">
								<div class="col-12 col-sm-4 col-md-4 col-lg-4 mb-3">
									<label for="floatName" class="fw-bold mb-2" for="floatEmail">Edad</label>
									<input type="text" inputmode="numeric" class="form-control" id="floatName" placeholder="">
								</div>
							
								<div class="col-12 col-sm-8 col-md-8 col-lg-8 mb-3">
									<label for="" class="fw-bold mb-2" for="floatEmail">Sexo</label>
									<div class="form-group">
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
											<label class="form-check-label" for="inlineRadio1">Hombre</label>
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
											<label class="form-check-label" for="inlineRadio2">Mujer</label>
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3">
											<label class="form-check-label" for="inlineRadio3">Otros</label>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-12 col-sm-4 col-md-6 col-lg-4 mb-4">
									<label class="fw-bold mb-2">Departamento <span class="label-advertencia text-danger"> *</span></label>
									<div class="form-group">
										<select name="cbo-departamento" id="cbo-departamento" class="form-select">
										<option value="0" selected="selected">- Seleccionar -</option>
										</select>
									</div>
									<span class="help-block text-danger" id="error"></span>
								</div>

								<div class="col-12 col-sm-4 col-md-6 col-lg-4 mb-4">
								<label class="fw-bold mb-2">Provincia <span class="label-advertencia text-danger"> *</span></label>
								<div class="form-group">
									<select name="cbo-provincia" id="cbo-provincia" class="form-select">
									<option value="0" selected="selected">- Seleccionar -</option>
									</select>
								</div>
								<span class="help-block text-danger" id="error"></span>
								</div>

								<div class="col-12 col-sm-4 col-md-6 col-lg-4 mb-4">
								<label class="fw-bold mb-2">Distrito <span class="label-advertencia text-danger"> *</span></label>
								<div class="form-group">
									<select name="cbo-distrito" id="cbo-distrito" class="form-select">
										<option value="0" selected="selected">- Seleccionar -</option>
									</select>
								</div>
									<span class="help-block text-danger" id="error"></span>
								</div>
							</div>
							
							<div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
								<button type="button" class="w-100 btn btn-success btn-lg">Crear cuenta</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</main>

		<div class="container py-3 pb-3">
			<footer class="pt-4 my-md-5 pt-md-5 pb-5 border-top">
				<div class="row">
					<div class="col-12 col-md">
						<img class="mb-2" src="assets/images/logo_probusiness.png?ver=5.0.0" alt="" height="60">
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

    <!--interno-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput-jquery.min.js"></script>

    <script src="assets/js/inicio.js?ver=74.0.0"></script>
  </body>
</html>
