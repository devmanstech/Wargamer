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
                <form id="profile_form" action="<?php echo site_url('user/manage_profile/update_profile_info/'.$user_info['id']); ?>" method="post" enctype="multipart/form-data" role="form" class="form-horizontal form-groups-bordered">
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

                	<div class="form-group">
                		<label for="phone" class="col-sm-3 control-label"><?php echo get_phrase('phone'); ?></label>
                		<div class="col-sm-7">
                			<input type="text" name="phone" value="<?php echo $user_info['phone'];?>" class="form-control" id="phone" placeholder="Phone">
                		</div>
                	</div>

                	<div class="form-group">
                		<label for="facebook" class="col-sm-3 control-label"><?php echo get_phrase('facebook'); ?></label>
                		<div class="col-sm-7">
                			<input type="text" class="form-control" name="facebook" placeholder="<?php echo get_phrase('write_down_facebook_url') ?>" value="<?php echo $social_links['facebook']; ?>">
                		</div>
                	</div>

                	<div class="form-group">
                		<label for="twitter" class="col-sm-3 control-label"><?php echo get_phrase('twitter'); ?></label>
                		<div class="col-sm-7">
                			<input type="text" class="form-control" name="twitter" placeholder="<?php echo get_phrase('write_down_twitter_url') ?>" aria-describedby="twitter" value="<?php echo $social_links['twitter']; ?>">
                		</div>
                	</div>

                	<div class="form-group">
                		<label for="linkedin" class="col-sm-3 control-label"><?php echo get_phrase('linkedin'); ?></label>
                		<div class="col-sm-7">
                			<input type="text" class="form-control" name="linkedin" placeholder="<?php echo get_phrase('write_down_linkedin_url') ?>" aria-describedby="linkedin" value="<?php echo $social_links['linkedin']; ?>">
                		</div>
                	</div>

                	<div class="form-group">
                		<label for="address" class="col-sm-3 control-label"><?php echo get_phrase('address'); ?></label>
                		<div class="col-sm-7">
                			<textarea name="address" class="form-control" rows="8" cols="80"><?php echo $user_info['address'];?></textarea>
                		</div>
					</div>
					<input id="language" name="language" type="hidden" />
					<div class="form-group">
                		<label for="language" class="col-sm-3 control-label"><?php echo get_phrase('language'); ?></label>
                		<div class="col-sm-7">
	     					<span class="autocomplete-select"></span>
  
                		</div>
                	</div>
					
                    <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('user_image'); ?></label>

                    <div class="col-sm-7">

                      <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;" data-trigger="fileinput">
                          <img src="<?php echo $this->user_model->get_user_thumbnail($this->session->userdata('user_id')); ?>" alt="...">
                        </div>
                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
                        <div>
                          <span class="btn btn-white btn-file">
                            <span class="fileinput-new"><?php echo get_phrase('select_image'); ?></span>
                            <span class="fileinput-exists"><?php echo get_phrase('change'); ?></span>
                            <input type="file" name="user_image" accept="image/*">
                          </span>
                          <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput"><?php echo get_phrase('remove'); ?></a>
                        </div>
                      </div>
                    </div>
                  </div>
                	<div class="col-sm-offset-3 col-sm-5" style="padding-top: 10px;">
                		<a type="submit" class="btn btn-info" onClick={$('#profile_form').submit()}><?php echo get_phrase('update_profile'); ?></a>
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
                <form action="<?php echo site_url('user/manage_profile/change_password/'.$user_info['id']); ?>" method="post" enctype="multipart/form-data" role="form" class="form-horizontal form-groups-bordered">
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



<?php
$languages = $this->db->get('language')->result_array();
?>
<script src="<?php echo site_url('assets/backend/js/bundle.min.js');?>"></script>

<script>
	// multi select init for language

	var autocomplete = new SelectPure(".autocomplete-select", {
        options: [
			<?php
				foreach($languages as $language){?>
		 {
            label: "<?php echo $language['value'] ?>",
            value: "<?php echo $language['id'] ?>",
          },
				<?php

				}
				?>
         
        ],
        value: [
			<?php
				$user_langs = explode(',',$user_info['language']);
				foreach($user_langs as $user_lang){
					echo '"'.$user_lang.'",';
				}
			?>
			
		],
        multiple: true,
        autocomplete: true,
        icon: "fa fa-times",
        onChange: value => { $('#language').val(value.toString()); },
        classNames: {
          select: "select-pure__select",
          dropdownShown: "select-pure__select--opened",
          multiselect: "select-pure__select--multiple",
          label: "select-pure__label",
          placeholder: "select-pure__placeholder",
          dropdown: "select-pure__options",
          option: "select-pure__option",
          autocompleteInput: "select-pure__autocomplete",
          selectedLabel: "select-pure__selected-label",
          selectedOption: "select-pure__option--selected",
          placeholderHidden: "select-pure__placeholder--hidden",
          optionHidden: "select-pure__option--hidden",
        }
      });
</script>
<style>
      body {
        font-family: "Roboto", sans-serif;
      }

      .select-wrapper {
        margin: auto;
        max-width: 600px;
        width: calc(100% - 40px);
      }

      .select-pure__select {
        align-items: center;
        background: #f9f9f8;
        border-radius: 4px;
        border: 1px solid #ebedf2;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
        box-sizing: border-box;
        color: #363b3e;
        cursor: pointer;
        display: flex;
        font-size: 16px;
        font-weight: 500;
        justify-content: left;
        min-height: 44px;
        padding: 5px 10px;
        position: relative;
        transition: 0.2s;
        width: 100%;
      }

      .select-pure__options {
        border-radius: 4px;
        border: 1px solid rgba(0, 0, 0, 0.15);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
        box-sizing: border-box;
        color: #363b3e;
        display: none;
        left: 0;
        max-height: 221px;
        overflow-y: scroll;
        position: absolute;
        top: 50px;
        width: 100%;
        z-index: 5;
      }

      .select-pure__select--opened .select-pure__options {
        display: block;
      }

      .select-pure__option {
        background: #fff;
        border-bottom: 1px solid #e4e4e4;
        box-sizing: border-box;
        height: 44px;
        line-height: 25px;
        padding: 10px;
      }

      .select-pure__option--disabled {
        color: #e4e4e4;
      }

      .select-pure__option--selected {
        color: #e4e4e4;
        cursor: initial;
        pointer-events: none;
      }

      .select-pure__option--hidden {
        display: none;
      }

      .select-pure__selected-label {
        align-items: 'center';
        background: #66c2ef;
        border-radius: 4px;
        color: #fff;
        cursor: initial;
        display: inline-flex;
        justify-content: 'center';
        margin: 5px 10px 5px 0;
        padding: 3px 7px;
      }

      .select-pure__selected-label:last-of-type {
        margin-right: 0;
      }

      .select-pure__selected-label i {
        cursor: pointer;
        display: inline-block;
        margin-left: 7px;
      }

      .select-pure__selected-label img {
        cursor: pointer;
        display: inline-block;
        height: 18px;
        margin-left: 7px;
        width: 14px;
      }

      .select-pure__selected-label i:hover {
        color: #e4e4e4;
      }

      .select-pure__autocomplete {
        background: #f9f9f8;
        border-bottom: 1px solid #e4e4e4;
        border-left: none;
        border-right: none;
        border-top: none;
        box-sizing: border-box;
        font-size: 16px;
        outline: none;
        padding: 10px;
        width: 100%;
      }

     
    </style>
