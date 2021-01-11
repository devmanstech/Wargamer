<?php $social_link_for_footer = json_decode(get_frontend_settings('social_links'), true);?>
<footer class="plus_border">
	<div class="container margin_60_35">
		<div class="row">
			<div class="col-lg-4 col-md-6 col-sm-6">
				<a data-toggle="collapse" data-target="#collapse_ft_1" aria-expanded="false" aria-controls="collapse_ft_1" class="collapse_bt_mobile">
					<h3>Quick Links</h3>
					<div class="circle-plus closed">
						<div class="horizontal"></div>
						<div class="vertical"></div>
					</div>
				</a>
				<div class="collapse show" id="collapse_ft_1">
					<ul class="links">
						<li><a href="<?php echo site_url('home/about'); ?>"><?php echo get_phrase('about'); ?></a></li>
						<li><a href="<?php echo site_url('home/terms_and_conditions'); ?>"><?php echo get_phrase('terms_and_conditions'); ?></a></li>
						<li><a href="<?php echo site_url('home/privacy_policy'); ?>"><?php echo get_phrase('privacy_policy'); ?></a></li>
						<li><a href="<?php echo site_url('home/faq'); ?>"><?php echo get_phrase('FAQ'); ?></a></li>
					</ul>
				</div>
			</div>

	
		<div class="col-lg-4 col-md-6 col-sm-6">
			<a data-toggle="collapse" data-target="#collapse_ft_3" aria-expanded="false" aria-controls="collapse_ft_3" class="collapse_bt_mobile">
				<h3><?php echo get_phrase('contacts'); ?></h3>
				<div class="circle-plus closed">
					<div class="horizontal"></div>
					<div class="vertical"></div>
				</div>
			</a>
			<div class="collapse show" id="collapse_ft_3">
				<ul class="contacts">
					<li><i class="ti-home"></i><?php echo get_settings('address'); ?></li>
					<li><i class="ti-headphone-alt"></i><?php echo get_settings('phone'); ?></li>
					<li><i class="ti-email"></i><a href="#0"><?php echo get_settings('system_email'); ?></a></li>
				</ul>
			</div>
		</div>
		<div class="col-lg-4 col-md-6 col-sm-6">
			<div class="social-links">
				<h5><?php echo get_phrase('follow_us'); ?></h5>
				<ul>
					<li><a href="<?php echo $social_link_for_footer['facebook']; ?>"><i class="ti-facebook"></i></a></li>
					<li><a href="<?php echo $social_link_for_footer['twitter']; ?>"><i class="ti-twitter-alt"></i></a></li>
					<li><a href="<?php echo $social_link_for_footer['google']; ?>"><i class="ti-google"></i></a></li>
					<li><a href="<?php echo $social_link_for_footer['pinterest']; ?>"><i class="ti-pinterest"></i></a></li>
					<li><a href="<?php echo $social_link_for_footer['instagram']; ?>"><i class="ti-instagram"></i></a></li>
				</ul>
			</div>
		</div>
	</div>
	<!-- /row-->
	<hr>
	<div class="row justify-content-end">
		<div class="col-lg-6">
			<ul id="additional_links">
				<li><a href="<?php echo site_url('home/about'); ?>"><?php echo get_phrase('about'); ?></a></li>
				<li><a href="<?php echo site_url('home/terms_and_conditions'); ?>"><?php echo get_phrase('terms_and_conditions'); ?></a></li>
				<li><a href="<?php echo site_url('home/privacy_policy'); ?>"><?php echo get_phrase('privacy_policy'); ?></a></li>
				<li><a href="<?php echo site_url('home/faq'); ?>"><?php echo get_phrase('FAQ'); ?></a></li>
				<li><a href="<?php echo get_settings('footer_link'); ?>"><?php echo get_settings('footer_text'); ?></a></li>
			</ul>
		</div>
	</div>
</div>
</footer>
<!--/footer-->

<script>
	function more_category(){
		$.ajax({
			url: "<?php echo site_url('home/footer_more_category/'); ?>",
			success: function(response){
				$('#loader').show();
				setInterval(function(){
					$('#loader').hide();
					$('#footer_category').html(response);
				},1000);

			}
		});
	}
</script>