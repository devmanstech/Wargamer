<?php
//$countries  = $this->db->get('country')->result_array();
$rosters = $this->db->get('roster')->result_array();
?>
<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-primary" data-collapsed="0">
      <div class="panel-heading">
        <div class="panel-title">
          <?php echo get_phrase('add_match_form'); ?>
        </div>
      </div>
      <div class="panel-body">
        <form action="<?php echo site_url('user/matches/add'); ?>" method="post" enctype="multipart/form-data" role="form" class="form-horizontal form-groups-bordered match_add_form">
          <div class="col-md-12">
            <ul class="nav nav-tabs bordered"><!-- available classes "bordered", "right-aligned" -->
              <li class="active">
                <a href="#first" data-toggle="tab">
                  <span class="visible-xs"><i class="entypo-home"></i></span>
                  <span class="hidden-xs"><?php echo get_phrase('roster'); ?></span>
                </a>
              </li>

              <li>
                <a href="#sixth" data-toggle="tab">
                  <span class="visible-xs"><i class="entypo-cog"></i></span>
                  <span class="hidden-xs"><?php echo get_phrase('schedule'); ?></span>
                </a>
              </li>

              <li>
                <a href="#eighth" data-toggle="tab">
                  <span class="visible-xs"><i class="entypo-cog"></i></span>
                  <span class="hidden-xs"><?php echo get_phrase('type'); ?></span>
                </a>
              </li>

            </ul>

            <div class="tab-content">
              <div class="tab-pane active" id="first">
                <?php include 'add_match_roster.php'; ?>
              </div>


              <div class="tab-pane" id="sixth">
                <?php include 'add_match_schedule.php'; ?>
              </div>

              <div class="tab-pane" id="eighth">
                <?php include 'add_match_type.php'; ?>
              </div>

            </div>
          </div>
        </form>
      </div>
    </div>
  </div><!-- end col-->
</div>



