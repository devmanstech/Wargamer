<div class="sidebar-menu">
	<header class="logo-env" >

		<!-- logo collapse icon -->
		<div class="sidebar-collapse" style="margin-top: 0px;">
			<a href="#" class="sidebar-collapse-icon" onclick="hide_brand()">
				<i class="entypo-menu"></i>
			</a>
		</div>
		<script type="text/javascript">
		function hide_brand() {
			$('#branding_element').toggle();
		}
		</script>

		<!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
		<div class="sidebar-mobile-menu visible-xs">
			<a href="#" class="with-animation">
				<i class="entypo-menu"></i>
			</a>
		</div>
	</header>

	<div style=""></div>
	<ul id="main-menu" class="">
		<div style="text-align: -webkit-center;" id="branding_element">
			<img src="<?php echo base_url('assets/global/light_logo.png'); ?>"  style="max-height:30px;"/>
		</div>
		<br>
		<!-- Home -->
		<li class="<?php if ($page_name == 'dashboard') echo 'active'; ?> " style="border-top:1px solid #232540;">
			<a href="<?php echo site_url('user/dashboard'); ?>">
				<i class="fa fa-home"></i>
				<span><?php echo get_phrase('dashboard'); ?></span>
			</a>
		</li>



		<!-- Current Match -->
		<li class="<?php if ($page_name == 'current_match') echo 'active'; ?> ">
			<a href="<?php echo site_url('user/current_match'); ?>">
				<i class="fa fa-gamepad"></i>
				<span> <?php echo get_phrase('current_match'); ?></span>
			</a>
		</li>

		<!-- All Match -->
		<li class="<?php if ($page_name == 'matches') echo 'active'; ?> ">
			<a href="<?php echo site_url('user/matches'); ?>">
				<i class="fa fa-sitemap"></i>
				<span> <?php echo get_phrase('all_matches'); ?></span>
			</a>
		</li>

		<!-- Match -->
<!--		<li class="--><?php //if ($page_name == 'matches' || $page_name == 'match_add_wiz') echo 'opened active has-sub'; ?><!--">-->
<!--			<a href="#">-->
<!--				<i class="fa fa-sitemap"></i>-->
<!--				<span>--><?php //echo get_phrase('match'); ?><!--</span>-->
<!--			</a>-->
<!--			<ul>-->
<!---->
<!--				<li class="--><?php //if ($page_name == 'matches') echo 'active'; ?><!-- ">-->
<!--					<a href="--><?php //echo site_url('user/matches'); ?><!--">-->
<!--						<span><i class="entypo-dot"></i> --><?php //echo get_phrase('all_matches'); ?><!--</span>-->
<!--					</a>-->
<!--				</li>-->
<!---->
<!--				<li class="--><?php //if ($page_name == 'match_add_wiz') echo 'active'; ?><!-- ">-->
<!--					<a href="--><?php //echo site_url('user/match_form/add'); ?><!--">-->
<!--						<span><i class="entypo-dot"></i> --><?php //echo get_phrase('add_new_match'); ?><!--</span>-->
<!--					</a>-->
<!--				</li>-->
<!---->
<!--			</ul>-->
<!--		</li>-->


		<!-- Roster -->

		<li class="<?php if ( $page_name == 'rosters' || $page_name == 'roster_add' || $page_name == 'roster_edit') echo 'opened active has-sub'; ?>">
			<a href="#">
				<i class="fa fa-book-open"></i>
				<span><?php echo get_phrase('rosters'); ?></span>
			</a>
			<ul>
				<li class="<?php if ($page_name == 'rosters') echo 'active'; ?> ">
					<a href="<?php echo site_url('user/rosters'); ?>">
						<span><i class="entypo-dot"></i> <?php echo get_phrase('all_rosters'); ?></span>
					</a>
				</li>

				<li class="<?php if ($page_name == 'roster_add') echo 'active'; ?> ">
					<a href="<?php echo site_url('user/roster_form/add'); ?>">
						<span><i class="entypo-dot"></i> <?php echo get_phrase('roster_add'); ?></span>
					</a>
				</li>
			</ul>
		</li>

		<!-- History -->
<!--		<li class="--><?php //if ($page_name == 'history') echo 'active'; ?><!-- ">-->
<!--			<a href="--><?php //echo site_url('user/history'); ?><!--">-->
<!--				<i class="fa fa-book"></i>-->
<!--				<span> --><?php //echo get_phrase('history'); ?><!--</span>-->
<!--			</a>-->
<!--		</li>-->
			<!-- Manage Profile -->
			<li class="<?php if ($page_name == 'manage_profile') echo 'active'; ?>">
				<a href="<?php echo site_url('user/manage_profile'); ?>">
					<i class="fa fa-user"></i>
					<span><?php echo get_phrase('account'); ?></span>
				</a>
			</li>
	</ul>
</div>
