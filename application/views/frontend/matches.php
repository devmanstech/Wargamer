<div class="" style="background-color: #f5f8fa;">
	<div class="container margin_80_55">
		<div class="main_title_2">
			<span><em></em></span>
			<h2><?php echo get_phrase('popular_matches'); ?></h2>
		</div>
		<div class="row justify-content-center">
			<?php
			$this->db->order_by('name', 'asc');
			$matches = $this->crud_model->get_matches()->result_array();
			foreach ($matches as $key => $match):?>
			<div class="col-md-4 mb-3">
				<div class="match-title">
					<a href="<?php echo site_url('home/filter_listings?match='.slugify($match['name']).'&&amenity=&&video=0&&status=all'); ?>" style="color: unset;"><?php echo $match['name']; ?> <small style='font-size: 12px;'>(<?php echo count($this->frontend_model->get_match_wise_listings($match['id'])); ?>)</small></a>
				</div>
				<?php
				endforeach; ?>
			</div>
		<?php endforeach; ?>
		</div>
	</div>
</div>
