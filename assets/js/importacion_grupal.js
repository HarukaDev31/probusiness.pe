const getProductTemplate = (name, src,i) => {
	return `
        <div class="ps-md-3 px-4 px-md-0 my-4">
              <div class="h-100 p-0 bx-producto  flex-column flex-md-row justify-content-center ">
                  <div class="w-100 d-flex justify-content-center align-items-center" style="min-height:150px">
                        <div  id="spinner-${i}" class="spinner-border text-primary mx-auto" style="width:50px;height:50px"></div>
                        <img id="img-${i}" src="${src}" class="img-fluid d-none" alt="..."/>
                  </div>
                  <div class="bg-black box-pr p-3">
                     <h6 class="text-white mb-3">${name}</h6>
                     <a href="" class="text-white small2 justify-content-center text-center btn-product d-flex text-decoration-none text-center">
                         <i class="bi bi-arrow-right  ms-3 "></i>
                     </a>
                  </div>
              </div>
        </div>
        `;
};

const getTrendProducts = async () => {
	$.ajax({
		type: "POST",
		dataType: "json",
		url: base_url + "ImportacionGrupal/getTrendProducts",
	}).done(function (response) {
		response.forEach((product,i)=> {
            console.log(product,i);
			const productTemplate = getProductTemplate(
				product.No_Producto,
				product.No_Imagen_Item,
                i
			);
			$(".productos").append(productTemplate);
            $(`#img-${i}`).on('load', function() {
                $(`#spinner-${i}`).hide();
                $(`#img-${i}`).removeClass('d-none');   
            });
		});
		$(".productos").slick({
			slidesToShow: 3,
			slidesToScroll: 3,
			autoplay: false,
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
	});
};
getTrendProducts();
