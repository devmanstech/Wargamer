<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-primary" data-collapsed="0">
      <div class="panel-heading">
        <div class="panel-title">
          <?php echo get_phrase('roster_add_form'); ?>
        </div>
      </div>
      <div class="panel-body">
        <form action="<?php echo site_url('user/rosters/add'); ?>" method="post" enctype="multipart/form-data" role="form" class="form-horizontal form-groups-bordered">
          <div class="form-group">
            <label for="name" class="col-sm-3 control-label"><?php echo get_phrase('name'); ?></label>
            <div class="col-sm-7">
              <input type="text" class="form-control" name="name" id="name" placeholder="<?php echo get_phrase('name'); ?>" required>
            </div>
          </div>


          <div class="form-group">
            <label class="col-sm-3 control-label"><?php echo get_phrase('roster'); ?></label>

            <div class="col-sm-7">

              <div class="fileinput fileinput-new" data-provides="fileinput">

                <div class="fileinput-preview fileinput-exists thumbnail" ></div>
                <div>
                  <span class="btn btn-white btn-file">
                    <span class="fileinput-new"><?php echo get_phrase('choose_roster'); ?></span>
                    <span class="fileinput-exists"><?php echo get_phrase('change'); ?></span>
                    <input type="file" name="roster_file" accept=".rosz">
                  </span>
                  <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput"><?php echo get_phrase('remove'); ?></a>
                </div>
              </div>
            </div>
          </div>
          <input type="hidden" name="user_id" value="<?php echo $logged_in_user_id ?>" />
            
          <div class="col-sm-offset-3 col-sm-5" style="padding-top: 10px;">
            <button type="submit" class="btn btn-info"><?php echo get_phrase('add_roster'); ?></button>
          </div>
        </form>
      </div>
    </div>
  </div><!-- end col-->
</div>

<script>

</script>