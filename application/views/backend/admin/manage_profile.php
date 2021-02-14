<?php
    $social_links = json_decode($user_info['social'], true);
 ?>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title">
					<?php echo get_phrase('edit_profile'); ?>
				</div>
			</div>
			<div class="panel-body">
                <form action="<?php echo site_url('admin/manage_profile/update_profile_info/'.$user_info['id']); ?>" method="post" enctype="multipart/form-data" role="form" class="form-horizontal form-groups-bordered">
                	<div class="form-group">
                		<label for="name" class="col-sm-3 control-label"><?php echo get_phrase('name'); ?></label>
                		<div class="col-sm-7">
                			<input type="text" name="name" value="<?php echo $user_info['name'];?>" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Enter name" required>
                		</div>
                	</div>

                	<div class="form-group">
                		<label for="email" class="col-sm-3 control-label"><?php echo get_phrase('email'); ?></label>
                		<div class="col-sm-7">
                			<input type="email" name="email" value="<?php echo $user_info['email'];?>" class="form-control" id="email" placeholder="Enter email" required>
                		</div>
                	</div>

                	
                	<div class="col-sm-offset-3 col-sm-5" style="padding-top: 10px;">
                		<button type="submit" class="btn btn-info"><?php echo get_phrase('update_profile'); ?></button>
                	</div>
                </form>
			</div>
		</div>
	</div><!-- end col-->
</div>


<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title">
					<?php echo get_phrase('update_password'); ?>
				</div>
			</div>
			<div class="panel-body">
                <form action="<?php echo site_url('admin/manage_profile/change_password/'.$user_info['id']); ?>" method="post" enctype="multipart/form-data" role="form" class="form-horizontal form-groups-bordered">
                	<div class="form-group">
                		<label for="current_password" class="col-sm-3 control-label"><?php echo get_phrase('current_password'); ?></label>
                		<div class="col-sm-7">
                			<input type="password" name="current_password" class="form-control" id="current_password" placeholder="<?php echo get_phrase('current_password'); ?>" required>
                		</div>
                	</div>

                    <div class="form-group">
                		<label for="new_password" class="col-sm-3 control-label"><?php echo get_phrase('new_password'); ?></label>
                		<div class="col-sm-7">
                			<input type="password" name="new_password" class="form-control" id="new_password" placeholder="<?php echo get_phrase('new_password'); ?>" required>
                		</div>
                	</div>

                    <div class="form-group">
                		<label for="confirm_password" class="col-sm-3 control-label"><?php echo get_phrase('confirm_password'); ?></label>
                		<div class="col-sm-7">
                			<input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="<?php echo get_phrase('confirm_password'); ?>" required>
                		</div>
                	</div>

                	<div class="col-sm-offset-3 col-sm-5" style="padding-top: 10px;">
                		<button type="submit" class="btn btn-info"><?php echo get_phrase('update_password'); ?></button>
                	</div>
                </form>
			</div>
		</div>
	</div><!-- end col-->
</div>
