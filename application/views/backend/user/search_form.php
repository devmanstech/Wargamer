<?php

$rosters = $this->db->get('roster')->result_array();
$languages = $this->db->get('language')->result_array();
$main_modes = $this->db->get_where('mode',array('mode_slug'=> 0))->result_array();
$pt_modes = $this->db->get_where('mode',array('mode_slug'=> 1))->result_array();

?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <?php echo get_phrase('search_form'); ?>
                </div>
            </div>
            <div class="panel-body">
                <form action="<?php echo site_url('user/search/add'); ?>" method="post" enctype="multipart/form-data" role="form" class="form-horizontal form-groups-bordered match_add_form">
                    <div class="col-md-12">

                        <div class="row" style="margin-bottom: 15px;">
                            <div class="col-lg-6 col-sm-12">
                                <label><?php echo get_phrase('select_roster'); ?></label>
                                <select class="form-control selectboxit" name="<?php echo 'roster'; ?>" id="<?php echo 'roster'; ?>">

                                    <?php foreach($rosters as $roster){ ?>
                                        <option value="<?php echo $roster['id']; ?>"> <?php echo $roster['name'] ?> </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-lg-6 col-sm-12">
                                <label><?php echo get_phrase('select_language'); ?></label>
                                <select class="form-control selectboxit" name="<?php echo 'language'; ?>" id="<?php echo 'language'; ?>">

                                    <?php foreach($languages as $language){ ?>
                                        <option value="<?php echo $language['id']; ?>"> <?php echo $language['value'] ?> </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-lg-6 col-sm-12">
                                <label><?php echo get_phrase('select_mode'); ?></label>
                                <select class="form-control selectboxit" name="<?php echo 'main_mode'; ?>" id="<?php echo 'main_mode'; ?>" >
                                    <option value="0"> <?php echo 'Main mode (Default All)' ?> </option>
                                    <?php foreach($main_modes as $main_mode){ ?>
                                        <option value="<?php echo $main_mode['id']; ?>"> <?php echo $main_mode['name'] ?> </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-lg-6 col-sm-12">
                                <label> </label>
                                <select class="form-control selectboxit" name="<?php echo 'pt_mode'; ?>" id="<?php echo 'pt_mode'; ?>">
                                    <option value="0"> <?php echo 'Point mode (Default All)' ?> </option>
                                    <?php foreach($pt_modes as $pt_mode){ ?>
                                        <option value="<?php echo $pt_mode['id']; ?>"> <?php echo $pt_mode['name'] ?> </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <hr>


                        <button type="submit" class="btn btn-info" style="float: right;width: 20%"> Start</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- end col-->
</div>


