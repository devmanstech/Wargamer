<ol class="breadcrumb bc-3">
    <li>
        <a href="<?php echo site_url('admin/dashboard'); ?>">
            <i class="entypo-folder"></i>
            <?php echo get_phrase('dashboard'); ?>
        </a>
    </li>
    <li><a href="#" class="active"><?php echo get_phrase('map_settings'); ?></a> </li>
</ol>

<h2><?php echo $page_title; ?></h2>
<br />
<div class="row">
    <div class="col-md-12">
        <div class="col-md-7">
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title">
                        <?php echo get_phrase('map_settings');?>
                    </div>
                </div>
                <div class="panel-body">
                    <form class="" action="<?php echo site_url('admin/map_settings/map_update'); ?>" method="post">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="form-label"><?php echo get_phrase('google_map_API_key'); ?></label>
                                <div class="controls">
                                    <input type="text" name = "google_map_api_key" class="form-control" value="">
                                </div>
                            </div>

                            <div class="form-group">
                                <button class = "btn btn-success" type="submit" name="button"><?php echo get_phrase('update_map_settings'); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
