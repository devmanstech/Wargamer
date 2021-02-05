<div class="row">
  <div class="col-lg-7">
    <div class="panel panel-primary" data-collapsed="0">
      <div class="panel-heading">
        <div class="panel-title">
          <?php echo get_phrase('system_settings'); ?>
        </div>
      </div>
      <div class="panel-body">
        <form action="<?php echo site_url('admin/system_settings/system_update'); ?>" method="post" enctype="multipart/form-data" role="form" class="form-horizontal form-groups-bordered">
          <div class="form-group">
            <label for="website_title" class="col-sm-3 control-label"><?php echo get_phrase('website_title'); ?></label>
            <div class="col-sm-7">
              <input type="text" class="form-control" name="website_title" id="website_title" placeholder="<?php echo get_phrase('website_title'); ?>" value="<?php echo get_settings('website_title');  ?>" required>
            </div>
          </div>

          <div class="form-group">
            <label for="system_title" class="col-sm-3 control-label"><?php echo get_phrase('system_title'); ?></label>
            <div class="col-sm-7">
              <input type="text" class="form-control" name="system_title" id="system_title" placeholder="<?php echo get_phrase('system_title'); ?>" value="<?php echo get_settings('system_title');  ?>" required>
            </div>
          </div>

          <div class="form-group">
            <label for="system_email" class="col-sm-3 control-label"><?php echo get_phrase('system_email'); ?></label>
            <div class="col-sm-7">
              <input type="email" class="form-control" name="system_email" id="system_email" placeholder="<?php echo get_phrase('system_email'); ?>" value="<?php echo get_settings('system_email');  ?>" required>
            </div>
          </div>

          <div class="form-group">
            <label for="address" class="col-sm-3 control-label"><?php echo get_phrase('address'); ?></label>
            <div class="col-sm-7">
              <textarea name="address" class="form-control" rows="8" cols="80"><?php echo get_settings('address');  ?></textarea>
            </div>
          </div>

          <div class="form-group">
            <label for="phone" class="col-sm-3 control-label"><?php echo get_phrase('phone'); ?></label>
            <div class="col-sm-7">
              <input type="text" class="form-control" name="phone" id="phone" placeholder="<?php echo get_phrase('phone'); ?>" value="<?php echo get_settings('phone');  ?>">
            </div>
          </div>

        <div class="form-group">
          <label for="timezone" class="col-sm-3 control-label"><?php echo get_phrase('timezone'); ?></label>

          <div class="col-sm-7">
            <select name="timezone" id = "timezone" class="select2" data-allow-clear="true" data-placeholder="<?php echo get_phrase('select_timezone'); ?>">
              <?php $tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL); ?>
              <?php foreach ($tzlist as $tz): ?>
                <option value="<?php echo $tz; ?>" <?php if(get_settings('timezone') == $tz) echo 'selected'; ?>><?php echo $tz; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

       
        <div class="form-group">
          <label for="footer_text" class="col-sm-3 control-label"><?php echo get_phrase('footer_text'); ?></label>
          <div class="col-sm-7">
            <input type="text" class="form-control" name="footer_text" id="footer_text" placeholder="<?php echo get_phrase('text'); ?>" value="<?php echo get_settings('footer_text');  ?>">
          </div>
        </div>

        <div class="form-group">
          <label for="footer_link" class="col-sm-3 control-label"><?php echo get_phrase('footer_link'); ?></label>
          <div class="col-sm-7">
            <input type="url" class="form-control" name="footer_link" id="footer_link" placeholder="<?php echo get_phrase('url'); ?>" value="<?php echo get_settings('footer_link');  ?>">
          </div>
        </div>

        <div class="col-sm-offset-3 col-sm-5" style="padding-top: 10px;">
          <button type="submit" class="btn btn-info"><?php echo get_phrase('save'); ?></button>
        </div>
      </form>
    </div>
  </div>
</div><!-- end col-->
</div>
