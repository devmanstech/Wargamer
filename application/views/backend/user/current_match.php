<?php
if($match_id){
    $match = $this->db->get_where('match', array('id'=>$match_id))->result_array();

    $created_date = new DateTime($match[0]['created_at']);
    $date = new DateTime('now');
    $diff = $created_date->diff($date);
    
    if($match[0]['player1_id'] == $logged_in_user_id){
        $your_faction = $match[0]['player1_faction'];
        $you = ($this->db->get_where('user', array('id'=>$match[0]['player1_id']))->result_array())[0];
        $your_name = $you['name'];

        $opponent_faction = $match[0]['player2_faction'];
        $opponent = ($this->db->get_where('user', array('id'=>$match[0]['player2_id']))->result_array())[0];
        $opponent_name = $opponent['name'];

    }else{
        $your_faction = $match[0]['player2_faction'];
        $you = ($this->db->get_where('user', array('id'=>$match[0]['player2_id']))->result_array())[0];
        $your_name = $you['name'];

        $opponent_faction = $match[0]['player1_faction'];
        $opponent = ($this->db->get_where('user', array('id'=>$match[0]['player1_id']))->result_array())[0];
        $opponent_name = $opponent['name'];


    }

    ?>
    <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <?php echo get_phrase('current_match'); ?>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="row" style="margin-bottom: 15px;">
                        <div class="col-lg-6 col-md-12">
                        <span style="font-size:20px; color:blue">Created : </span> <span><?php echo $diff->format("%H hours %I min") ?> ago</span>
</div>
<div class="col-lg-6 col-md-12" >
                        <a class="btn btn-warning" style="float:right">In progress</a>
                        </div>
                    </div>
                
            
                </div>

                <div class="col-md-12">

                        <div class="row" style="margin-bottom: 15px;">
                            <div class="col-lg-6 col-md-12">
                                <span style="font-size:20px; color:blue"><?php echo get_phrase('you') ?></span>
                                <hr>
                                <p>
                                <label>Name : </label> <?php echo  $your_name?>
                                </p>
                                <p>
                                <label>Faction : </label> <?php echo  $your_faction?>
</p>
                            </div>
                            
                            <div class="col-lg-6 col-md-12">
                            <span style="font-size:20px; color:blue"><?php echo get_phrase('opponent'); ?></span>
                                <hr>
                                <p><label>Name : </label> <?php echo  $opponent_name?></p>
                                <p><label>Faction : </label> <?php echo  $opponent_faction?></p>
                                
                            </div>


                        </div>
                </div>
            </div>
        </div>
    </div><!-- end col-->
</div>

<?php 
}else{
    ?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <?php echo get_phrase('current_match'); ?>
                </div>
            </div>
            <div class="panel-body">
                <p>There isn't match yet!</p>
            </div>
        </div>
    </div><!-- end col-->
</div>

    <?php
}
 ?>
