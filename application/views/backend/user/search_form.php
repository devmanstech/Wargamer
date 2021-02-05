<?php

$rosters = $this->db->get_where('roster', array('user_id'=>$logged_in_user_id))->result_array();

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
                <form action="<?php echo site_url('user/search/add'); ?>" method="post" enctype="multipart/form-data" role="form" class="form-horizontal  match_add_form">
                    <div class="col-md-12">

                        <div class="row" style="margin-bottom: 15px;">
                            <div class="col-lg-6 col-sm-12">
                                <label><?php echo get_phrase('select_roster'), "*"; ?></label>
                                <select class="form-control selectboxit" name="<?php echo 'roster'; ?>" id="<?php echo 'roster'; ?>" required>
                               
                                    <?php foreach($rosters as $roster){ ?>
                                        <option value="<?php echo $roster['id']; ?>"> <?php echo $roster['name'] ?> </option>
                                    <?php } ?>
                                </select>
                            </div>

                            
                            <div class="col-lg-6 col-sm-12">
                                <label><?php echo get_phrase('select_mode'); ?></label>
                                <select class="form-control selectboxit" name="<?php echo 'main_mode'; ?>" id="<?php echo 'main_mode'; ?>" >
                                    
                                    <?php foreach($main_modes as $main_mode){ ?>
                                        <option value="<?php echo $main_mode['id']; ?>"> <?php echo $main_mode['name'] ?> </option>
                                    <?php } ?>
                                </select>
                            </div>


                        </div>
                        <hr>

                        <div class="row" style="margin-bottom: 15px;">
                                                        
                            <div class="col-lg-6 col-sm-12">
                                <label><?php echo get_phrase('faction'), " :"; ?></label>
                                <span id="faction"></span>
                            </div>

                            <div class="col-lg-6 col-sm-12">
                                <label><?php echo get_phrase('point'), " :"; ?></label>
                                <span id="point"></span>
                            </div>
                        </div>

                        <input type="hidden" name="language" value="<?php echo $logged_in_user_language ?>" />
                        <input type="hidden" name="faction" class="faction" />
                        <input type="hidden" name="point" class="point" />
                        <input type="hidden" name="user_id" value="<?php echo $logged_in_user_id ?>" />

                        <hr>


                        <button type="submit" class="btn btn-info" style="float: right;width: 20%"> Start</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- end col-->
</div>


<?php
if(count($rosters)>0){
    ?>
    <script>
var rosters = JSON.parse('<?php echo json_encode($rosters) ?>');

function get_roster_by_id(id){
    
    for(var i=0;i<rosters.length; i++){
        if(rosters[i]['id'] == id){
            return rosters[i];
        }
    }
}


$(document).ready(function(){
  

    var roster_id = $('#roster').val();
    var roster = get_roster_by_id(roster_id);
    
    $('#faction').html(roster['catalogue_name']);
    $('input.faction').val(roster['catalogue_name']);
    $('#point').html(roster['cost']);
    $('input.point').val(roster['cost']);
})

$('#roster').change(function(){
   
    var roster_id = this.value;
    var roster = get_roster_by_id(roster_id);
    
    $('#faction').html(roster['catalogue_name']);
    $('input.faction').val(roster['catalogue_name']);
    $('#point').html(roster['cost']);
    $('input.point').val(roster['cost']);

})
</script>



    <?php
}
?>

