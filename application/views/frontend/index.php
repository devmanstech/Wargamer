<!DOCTYPE html>
<html lang="en">

	<head>

	    <!-- Meta tags and seo configuration -->
	    <?php include 'site_meta.php';?>

	    <!-- Top css library files -->
	    <?php include 'includes_top.php';?>

	</head>

	<body>
		<div id="page">

			<!-- Header -->
			<?php
			if ($page_name == 'home' || $page_name == '404')
				include 'header_home.php';
			
			else
				include 'header.php';
			?>

			<!-- Main page -->
			<main>
				<?php include $page_name . '.php'; ?>
			</main>

			<!-- Site footer -->
			<?php
				include 'footer.php';
			?>
		</div>

		<!-- Signin popup -->
		<?php include 'signin_popup.php';?>

		<!-- Back to top button -->
		<div id="toTop"></div>

		<!-- Bottom js library files -->
		<?php include 'includes_bottom.php';?>
		
		<!--modal-->
		<?php include 'modal.php'; ?>
		<?php
			if(get_frontend_settings('cookie_status') == 1):
				include 'eu-cookie.php';
			endif;
		?>

	</body>
</html>
