<?php

$rosters = $this->db->get('roster')->result_array();
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
                <form action="<?php echo site_url('user/search/stop'); ?>" method="post" enctype="multipart/form-data" role="form" class="form-horizontal form-groups-bordered match_add_form">
                    <div class="col-md-12">

                        <div class="row" style="margin-bottom: 15px;">
                            <div class="col-lg-12">
                                <label><?php echo get_phrase('select_roster'); ?></label>
                                <select class="form-control selectboxit" name="<?php echo 'roster'; ?>" id="<?php echo 'roster'; ?>">

                                    <?php foreach($rosters as $roster){ ?>
                                        <option value="<?php echo $roster['id']; ?>"> <?php echo $roster['name'] ?> </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <hr>


                        <button type="submit" class="btn btn-info" style="float: right;width: 20%"><i class="fa fa-search"></i> Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- end col-->
</div>


