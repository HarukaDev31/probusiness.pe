<main>
	<?php //array_debug($response_izipay); ?>
	<br><br><br><br>
	<div class="container mt-5 mb-5">
		<?php if($response_izipay['status']=='success') { ?>
			<h2 class="text-center mt-5 mb-4 pt-3 text-success"><i class="fa-solid fa-circle-check fa-3x text-green"></i></h2>
			<h2 class="text-center mb-5"><?php echo $response_izipay['message']; ?></h2>
		<?php } else { ?>
			<h2 class="text-center mt-5 mb-4 pt-3 text-success"><i class="fas fa-exclamation-circle fa-3x text-warning"></i></h2>
			<h2 class="text-center mb-5"><?php echo $response_izipay['message']; ?></h2>
		<?php } ?>
	</div>
	<br><br><br>
</main>