<?php require 'includes/header.php'; ?>

<div class="card-body">
	<h1 class="text-center font-weight-bold">ABOUT SCHOOL</h1><hr>

	<div class="card-body">
		<img src="<?php echo $up_img_path.$setting['school_image']; ?>" class="w-100 img-fluid">

		<p class="mt-5 text-justify">
			<?php echo $setting['school_about']; ?>
		</p>
		
		<div class='card-body m-3'>
		    <div class='float-right text-center'>
		        <h5>School Authority</h5>
		        <h6><?php echo $setting['school_name']; ?></h6>
		    </div>
		</div>
		
	</div>
</div><br><br>

<?php require 'includes/footer.php'; ?>