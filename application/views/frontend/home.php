<section class="hero_single version_2" style="background: #222 url(<?php echo base_url('uploads/system/home_banner.jpg'); ?>) center center no-repeat; background-size: cover;">
	<div class="wrapper">
		<div class="container">
			<h3><?php echo get_frontend_settings('banner_title'); ?>!</h3>
			<p><?php echo get_frontend_settings('slogan'); ?></p>
			<form action="<?php echo site_url('home/search'); ?>" method="get">
				<div class="row no-gutters custom-search-input-2">
					<div class="col-lg-7">
						<div class="form-group">
							<input class="form-control" type="text" name="search_string" placeholder="<?php echo get_phrase('what_are_you_looking_for'); ?>...">
							<i class="icon_search"></i>
						</div>
					</div>
					<div class="col-lg-3">
						<select class="wide" name="selected_category_id">
							<option value=""><?php echo get_phrase('all_categories'); ?></option>
							<?php
							$categories = $this->crud_model->get_categories()->result_array();
							foreach ($categories as $category):?>
								<option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="col-lg-2">
						<input type="submit" value="Search">
					</div>
				</div>
				<!-- /row -->
			</form>
		</div>
	</div>
</section>
<!-- /hero_single -->

<div class="bg_color_1">
	<div class="container margin_80_55">
		<div class="main_title_2">
			<span><em></em></span>
			<h2><?php echo get_phrase('popular_categories'); ?></h2>
			<p><?php echo get_phrase('the_popular_categories_are_progressively_below'); ?>.</p>
		</div>
		<div class="row" id="home_category">
			<!-- Single Item of popular category starts -->
			<?php
			$this->db->limit(9);
			$categories = $this->db->get_where('category', array('parent' => 0))->result_array();
			foreach ($categories as $key => $category):?>
			<div class="col-lg-4 col-md-6">
				<a href="<?php echo site_url('home/filter_matches?category='.slugify($category['name']).'&&amenity=&&video=0&&status=all'); ?>" class="grid_item">
					<figure>
						<img src="<?php echo base_url('uploads/category_thumbnails/').$category['thumbnail'];?>" alt="">
						<div class="info">
							<small><?php echo count($this->frontend_model->get_category_wise_matches($category['id'])).' '.get_phrase('matches'); ?></small>
							<h3><?php echo $category['name']; ?></h3>
						</div>
					</figure>
				</a>
			</div>
			<?php endforeach; ?>
			<div class="col-12 text-center" id="home_category_loader" style="display: none; opacity: .5;">
				<img src="<?php echo base_url('assets/frontend/images/loader.gif'); ?>" width="50">
			</div>
			<!-- Single Item of popular category ends -->
			<?php $category_array_count = count($this->db->get_where('category', array('parent' => 0))->result_array()); ?>
			<?php if($category_array_count > 9): ?>
				<div class="col-12">
					<a href="javascript: void(0)" class="float-right btn_1 rounded" onclick="home_categories()"><?php echo get_phrase('view_all'); ?></a>
				</div>
			<?php endif; ?>
		</div>
	<!-- /row -->
</div>
<!-- /container -->
</div>
<!-- /bg_color_1 -->

<div class="container-fluid margin_80_55">
	<div class="main_title_2">
		<span><em></em></span>
		<h2><?php echo get_phrase('popular_matches'); ?></h2>
	</div>

	<div id="reccomended" class="owl-carousel owl-theme">
		<?php // $match_number = 0; ?>
		<?php $matches = $this->frontend_model->get_top_ten_matches();

		

		// foreach ($matches as $key => $match):
		// 	$package_id = has_package($match['user_id']);
		// 	$total_match = $this->db->get_where('package_purchased_history', array('id', $package_id))->row('number_of_matches');

		// 	$matches_2 = $this->db->get_where('match', array('user_id' => $match['user_id']));
		// 	foreach($matches_2 as $match_2){
		// 		$match_number++;
		// 		if($match_number < $total_match || $match_number == $total_match){
		// 			echo 'show, ';
		// 		}
		// 	}
		// endforeach;


		foreach ($matches as $key => $match): ?>
		<div class="item">
			<div class="strip grid">
				<figure>

					<!--redirect to routs file-->
					<a href="<?php echo get_match_url($match['id']); ?>"><img src="<?php echo base_url('uploads/match_thumbnails/'.$match['match_thumbnail']); ?>" class="img-fluid" alt="" width="400" height="266"><div class="read_more"><span>Read more</span></div></a>
					<small><?php echo $match['match_type'] == "" ? ucfirst(get_phrase('general')) : ucfirst(get_phrase($match['match_type'])) ; ?></small>
				</figure>
				<div class="wrapper">
					<h3>
						<a href="<?php echo get_match_url($match['id']); ?>" class="float-left"><?php echo $match['name']; ?></a>
						<?php $claiming_status = $this->db->get_where('claimed_match', array('match_id' => $match['id']))->row('status'); ?>
		                <?php if($claiming_status == 1): ?>
						        <img class="float-left ml-1" data-toggle="tooltip" title="<?php echo get_phrase('this_match_is_verified'); ?>" src="<?php echo base_url('assets/frontend/images/verified.png'); ?>" style="width: 25px;">
						<?php endif; ?>
					</h3>
					<br>
					<p class="mt-1"><?php echo substr($match['description'], 0, 100) . '...'; ?>.</p>
					<a class="address" href="http://maps.google.com/maps?q=<?php echo $match['latitude']; ?>,<?php echo $match['longitude']; ?>" target="_blank"><?php echo get_phrase('get_directions'); ?></a>
				</div>
				<ul>
					<!-- <li><span class="loc_open"><?php echo now_open($match['id']); ?></span></li> -->
					<li><span class="<?php echo strtolower(now_open($match['id'])) == 'closed' ? 'loc_closed' : 'loc_open'; ?>"><?php echo now_open($match['id']); ?></span></li>
					<li><div class="score"><span>
						<?php
						if ($this->frontend_model->get_match_wise_rating($match['id']) > 0) {
							$quality = $this->frontend_model->get_rating_wise_quality($match['id']);
							echo $quality['quality'];
						}else {
							echo get_phrase('unreviewed');
						}
						?>
						<em><?php echo count($this->frontend_model->get_match_wise_review($match['id'])).' '.get_phrase('reviews'); ?></em></span><strong><?php echo $this->frontend_model->get_match_wise_rating($match['id']); ?></strong></div></li>
					</ul>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<!-- /carousel -->
	<div class="container">
		<div class="btn_home_align"><a href="<?php echo site_url('home/matches'); ?>" class="btn_1 rounded"><?php echo get_phrase('view_all'); ?></a></div>
	</div>
	<!-- /container -->
</div>
<!-- /container -->


<!-- /container -->

<script>
	function home_categories(limitation){
		$.ajax({
			url: "<?php echo site_url('home/home_categories/'); ?>",
			success: function(response){
				$('#home_category_loader').show();
				setInterval(function(){
					$('#home_category_loader').hide();
					$('#home_category').html(response);
				},1500);

			}
		});
	}
</script>
