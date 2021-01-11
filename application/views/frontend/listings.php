<?php
	
    $listings_view = $this->session->userdata('listings_view');
    if($listings_view == 'list_view'){
        $listing_view_type = 'list_view';
    }else{
        $listing_view_type = 'grid_view';
    }

	include 'listings_'.$listing_view_type.'.php';

?>
<script>
	$(document).ready(function(){
		// $.ajax({
		// 	url: "<?php echo site_url('home/listings'); ?>",
		// 	success: function(){
		// 		//alert();
		// 		//location.reload();
		// 	}
		// });

	});
</script>