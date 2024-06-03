/*
document.querySelector('.bx-portada').addEventListener('mouseover', function () {
  this.classList.add('hovered');
});
*/

function checkEmail(email) {
	var caract = new RegExp(
		/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/
	);
	if (caract.test(email) == false) {
		$("#correo")
			.closest(".form-group")
			.find(".help-block")
			.html("Email inválido");
		$("#correo")
			.closest(".form-group")
			.removeClass("text-success")
			.addClass("text-danger");
		$("#correo")
			.closest(".form-group")
			.find(".help-block")
			.removeClass("text-success");
		return false;
	} else {
		$("#correo")
			.closest(".form-group")
			.find(".help-block")
			.html("Email válido");
		$("#correo")
			.closest(".form-group")
			.addClass("text-success")
			.removeClass("text-danger");
		$("#correo")
			.closest(".form-group")
			.find(".help-block")
			.removeClass("text-danger");
		return true;
	}
}

function checkEmailTienda(email) {
	var caract = new RegExp(
		/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/
	);
	if (caract.test(email) == false) {
		$("#txt-email")
			.closest(".form-group")
			.find(".help-block")
			.html("Email inválido");
		$("#txt-email")
			.closest(".form-group")
			.removeClass("text-success")
			.addClass("text-danger");
		$("#txt-email")
			.closest(".form-group")
			.find(".help-block")
			.removeClass("text-success");
		return false;
	} else {
		$("#txt-email")
			.closest(".form-group")
			.find(".help-block")
			.html("Email válido");
		$("#txt-email")
			.closest(".form-group")
			.addClass("text-success")
			.removeClass("text-danger");
		$("#txt-email")
			.closest(".form-group")
			.find(".help-block")
			.removeClass("text-danger");
		return true;
	}
}

$("#terminos").on("click", function () {
	if ($(this).is(":checked")) {
		// Hacer algo si el checkbox ha sido seleccionado
		$("#btnEnvio").attr("disabled", false);
		$("#btnEnvio").removeClass("bg-secondary");
		$("#btnEnvio").removeClass("text-white");
		$("#btnEnvio").addClass("fondo-verde");
		$("#btnEnvio").addClass("color-azul");
	} else {
		// Hacer algo si el checkbox ha sido deseleccionado
		$("#btnEnvio").attr("disabled", true);
	}
});

$(document).on("click", ".open-menu", function () {
	$(".box-menu-all").addClass("active");
});

$(document).on("click", ".close-menu", function () {
	$(".box-menu-all").removeClass("active");
});

$(document).on("click", ".item-menu-unique", function () {
	$(".box-menu-all").removeClass("active");
});

$(document).ready(function () {
	$(".collaborator").slick({
		slidesToShow: 2,
		slidesToScroll: 1,
		autoplay: true,
		autoplaySpeed: 5000,

		dots: false,
		arrows: false,
		responsive: [
			{
				breakpoint: 769,
				settings: {
					arrows: false,
					centerMode: false,
					slidesToShow: 1,
				},
			},
			{
				breakpoint: 564,
				settings: {
					centerMode: false,
					slidesToShow: 1,
					slidesToScroll: 1,
				},
			},
		],
	});

	$(".custom-prev-button").click(function () {
		$(".collaborator").slick("slickPrev");
	});

	$(".custom-next-button").click(function () {
		$(".collaborator").slick("slickNext");
	});

	function updateCustomDots(slick, currentIndex) {
		$(".custom-dot").removeClass("active"); // Elimina la clase "active" de todos los dots
		$(".custom-dot:eq(" + currentIndex + ")").addClass("active"); // Agrega la clase "active" al dot actual
	}

	// Inicializa los dots personalizados
	updateCustomDots($(".collaborator"), 0);

	// Configura los dots personalizados para cambiar de diapositiva al hacer clic
	$(".custom-dot").click(function () {
		var dotIndex = $(this).index();
		$(".collaborator").slick("slickGoTo", dotIndex);
	});

	// Configura un evento de Slick Slider para actualizar los dots personalizados
	$(".collaborator").on("afterChange", function (event, slick, currentSlide) {
		updateCustomDots(slick, currentSlide);
	});

	// shorts

	$(".shorts").slick({
		slidesToShow: 3,
		slidesToScroll: 1,
		autoplay: false,
		infinite: true,
		autoplaySpeed: 5000,
		dots: false,
		arrows: false,
		responsive: [
			{
				breakpoint: 821,
				settings: {
					slidesToShow: 2,
				},
			},
			{
				breakpoint: 560,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				},
			},
		],
	});

	$(".custom-prev-button-short").click(function () {
		$(".shorts").slick("slickPrev");
	});

	$(".custom-next-button-short").click(function () {
		$(".shorts").slick("slickNext");
	});

	$(".beneficios").slick({
		slidesToShow: 2,
		slidesToScroll: 1,
		autoplay: true,
		autoplaySpeed: 5000,

		dots: false,
		arrows: false,
		responsive: [
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 1,
				},
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				},
			},
		],
	});

	$(".custom-prev-button-short").click(function () {
		$(".beneficios").slick("slickPrev");
	});

	$(".custom-next-button-short").click(function () {
		$(".beneficios").slick("slickNext");
	});

	$(".services").slick({
		slidesToShow: 4,
		slidesToScroll: 1,
		autoplay: true,
		autoplaySpeed: 5000,
		dots: false,
		arrows: false,
		responsive: [
			{
				breakpoint: 821,
				settings: {
					arrows: false,
					centerMode: false,
					slidesToShow: 2,
				},
			},
			{
				breakpoint: 480,
				settings: {
					centerMode: false,
					initialSlide: 0,
					slidesToShow: 1,
					slidesToScroll: 1,
				},
			},
		],
	});

	$(".custom-prev-button-services").click(function () {
		$(".services").slick("slickPrev");
	});

	$(".custom-next-button-services").click(function () {
		$(".services").slick("slickNext");
	});

	$(".rutacarga").slick({
		slidesToShow: 3,
		slidesToScroll: 1,
		autoplay: true,
		autoplaySpeed: 5000,
		dots: false,
		arrows: false,
		responsive: [
			{
				breakpoint: 821,
				settings: {
					arrows: false,
					centerMode: false,
					slidesToShow: 3,
				},
			},
			{
				breakpoint: 480,
				settings: {
					centerMode: false,
					initialSlide: 0,
					slidesToShow: 1,
					slidesToScroll: 1,
				},
			},
		],
	});

	$(".custom-prev-button-services").click(function () {
		$(".rutacarga").slick("slickPrev");
	});

	$(".custom-next-button-services").click(function () {
		$(".rutacarga").slick("slickNext");
	});

	$(".satisfechos").slick({
		slidesToShow: 4,
		slidesToScroll: 1,
		autoplay: true,
		autoplaySpeed: 5000,
		dots: true,
		arrows: false,
		responsive: [
			{
				breakpoint: 768,
				settings: {
					arrows: false,
					centerMode: false,
					centerPadding: "40px",
					slidesToShow: 2.5,
				},
			},
			{
				breakpoint: 480,
				settings: {
					centerMode: false,
					initialSlide: 0,
					slidesToShow: 1.5,
					slidesToScroll: 1,
				},
			},
		],
	});

	//call base_url +getTrendProducts with ajax and append to the div
	$url = base_url + "ImportacionGrupal/getTrendProducts";
	$.ajax({
		url: $url,
		type: "GET",
		success: function (data) {
      data = JSON.parse(data);
			data.forEach((product) => {
        $(".productos").append(getProductTemplate(product));
      });
			$(".productos").slick({
				slidesToShow: 3,
				slidesToScroll: 3,
				autoplay: true,
				autoplaySpeed: 5000,
				dots: true,
				arrows: false,
				responsive: [
					{
						breakpoint: 821,
						settings: {
							arrows: false,
							centerMode: false,
							slidesToShow: 3,
						},
					},
					{
						breakpoint: 480,
						settings: {
							centerMode: false,
							initialSlide: 0,
							slidesToShow: 1,
							slidesToScroll: 1,
						},
					},
				],
			});
		},
	});
	const getProductTemplate = (product) => {
		return `<div class="ps-md-3 px-4 px-md-0 my-4">
  <div class="h-100 p-0 bx-producto  flex-column flex-md-row justify-content-center ">
      <div class="w-100">
          <img src="${product.No_Imagen_Item}" class="w-100 img-fluid" alt="">
      </div>
      <div class="bg-black box-pr p-3">
         <h6 class="text-white mb-3">${product.No_Producto}</h6>
      </div>
      
  </div>
</div>`;
	};
	$(".marcas").slick({
		slidesToShow: 6,
		slidesToScroll: 1,
		center: false,
		autoplay: true,
		autoplaySpeed: 2000,
		dots: false,
		arrows: false,
		responsive: [
			{
				breakpoint: 800,
				settings: {
					arrows: false,
					centerMode: false,
					slidesToShow: 3,
				},
			},
			{
				breakpoint: 480,
				settings: {
					centerMode: false,
					initialSlide: 0,
					slidesToShow: 3,
					slidesToScroll: 1,
				},
			},
		],
	});

	$(".tiendasbox").slick({
		slidesToShow: 4,
		slidesToScroll: 1,
		center: true,
		autoplay: true,
		autoplaySpeed: 5000,
		dots: false,
		centerMode: true,
		arrows: false,
		responsive: [
			{
				breakpoint: 890,
				settings: {
					arrows: false,
					centerMode: false,
					centerPadding: "40px",
					slidesToShow: 2,
				},
			},
			{
				breakpoint: 480,
				settings: {
					arrows: false,
					centerMode: false,
					centerPadding: "40px",
					slidesToShow: 1,
				},
			},
		],
	});

	$(".custom-prev-button-tienda").click(function () {
		$(".tiendasbox").slick("slickPrev");
	});

	$(".custom-next-button-tienda").click(function () {
		$(".tiendasbox").slick("slickNext");
	});

	function updateCustomDotsTienda(slick, currentIndex) {
		$(".custom-dot-tienda").removeClass("active"); // Elimina la clase "active" de todos los dots
		$(".custom-dot-tienda:eq(" + currentIndex + ")").addClass("active"); // Agrega la clase "active" al dot actual
	}

	// Inicializa los dots personalizados
	updateCustomDotsTienda($(".tiendasbox"), 0);

	// Configura los dots personalizados para cambiar de diapositiva al hacer clic
	$(".custom-dot-tienda").click(function () {
		var dotIndex = $(this).index();
		$(".tiendasbox").slick("slickGoTo", dotIndex);
	});

	// Configura un evento de Slick Slider para actualizar los dots personalizados
	$(".tiendasbox").on("afterChange", function (event, slick, currentSlide) {
		updateCustomDotsTienda(slick, currentSlide);
	});
});

function playVideoAgenteViajes(id) {
	var iframe = document.getElementById(id);
	iframe.src += "?autoplay=1"; // Esto inicia la reproducción

	$("." + id).addClass("d-none");
	$(".video-agente_viajes").removeClass("position-absolute");
	$(".video-agente_viajes").removeClass("d-none");
}

function playVideoCurso(id) {
	var iframe = document.getElementById(id);
	iframe.src += "?autoplay=1"; // Esto inicia la reproducción

	$("." + id).addClass("d-none");
	$(".video-curso").removeClass("position-absolute");
	$(".video-curso").removeClass("d-none");
}

function playVideoCargaConsolidada(id) {
	var iframe = document.getElementById(id);
	iframe.src += "?autoplay=1"; // Esto inicia la reproducción

	$("." + id).addClass("d-none");
	$(".video-carga_consolidada").removeClass("position-absolute");
	$(".video-carga_consolidada").removeClass("d-none");
}

function playVideoAgenteCompra(id) {
	var iframe = document.getElementById(id);
	iframe.src += "?autoplay=1"; // Esto inicia la reproducción

	$("." + id).addClass("d-none");
	$(".video-agente_compra").removeClass("position-absolute");
	$(".video-agente_compra").removeClass("d-none");
}

function playVideo(id) {
	var iframe = document.getElementById(id);
	iframe.src += "&autoplay=1"; // Esto inicia la reproducción

	$("." + id).addClass("d-none");
	$(".view-iframe").removeClass("position-absolute");
}

function playVideo2(id) {
	var iframe = document.getElementById(id);
	iframe.src += "&autoplay=1"; // Esto inicia la reproducción

	$("." + id).addClass("d-none");
	$(".view-iframe2").removeClass("position-absolute");
}
