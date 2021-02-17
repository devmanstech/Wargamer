<?php
    $matches1 = $this->db->get_where('match', array('player1_id'=>$logged_in_user_id))->result_array();
    $matches2 = $this->db->get_where('match', array('player2_id'=>$logged_in_user_id))->result_array();
?>

<style>
    table {

        border-spacing: 0;
        width: 100%;

    }

    th, td {
        text-align: center;
            }


</style>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <?php echo get_phrase('general_match_list'); ?>
                </div>
            </div>
            <div class="panel-body">
                <table id="match_table" class="stripe" style="width:100%;font-size:14px">
                    <thead>
                    <tr>
                        <th width="20"><div>ID</div></th>

                        <th width="20%"><div><?php echo get_phrase('your_faction');?></div></th>
                        <th width="20%"><div><?php echo get_phrase('opponent');?></div></th>
                        <th width="20%"><div><?php echo get_phrase('opponent_faction');?></div></th>
                        <th width="20%"><div><?php echo get_phrase('winner');?></div></th>
                        <th width="20%"><div><?php echo get_phrase('status');?></div></th>
                        <th><div><?php echo get_phrase('option');?></div></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    // $counter = 0;
                    foreach ($matches1 as $match):
                        // $faction1 = $this->db->get_where('faction', array('id'=>$match['player1_faction']))->result_array();
                        $faction1 =$match['player1_faction'];
                        $opponent = $this->db->get_where('user', array('id'=>$match['player2_id']))->result_array();
                        $opponent_name = $opponent[0]['name'];
                        // $faction2 = $this->db->get_where('faction', array('id'=>$match['player2_faction']))->result_array();
                        $faction2 =$match['player2_faction'];
                        if($match['status'] && $match['winner'] != '0') {
                            $winner = $this->db->get_where('user', array('id'=>$match['winner']))->result_array();
                            $winner_name = $winner[0]['name'];
                        }else{
                            $winner_name = 'None';
                        }
                        
                        ?>
                        <tr>

                            <td><?php echo $match['id']; ?></td>
                            <td><?php echo $faction1; ?></td>
                            <td><?php echo $opponent_name; ?></td>
                            <td><?php echo $faction2; ?></td>
                            <td><?php echo $winner_name ?></td>
                            <td><?php echo $match['status']? 'Completed': 'In Progress'; ?></td>

                            <td>
                                <div class="bs-example">
                                    <div class="btn-group">
                                        <a href="<?php echo site_url('user/match_form/view/'.$match['id']); ?>" class="btn btn-info">
                                            <i class="entypo-pencil"></i>
                                            <?php echo get_phrase('view'); ?>
                                        </a>

                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; 
                    foreach ($matches2 as $match):
                        // $faction1 = $this->db->get_where('faction', array('id'=>$match['player1_faction']))->result_array();
                        $faction1 =$match['player2_faction'];
                        $opponent = $this->db->get_where('user', array('id'=>$match['player1_id']))->result_array();
                        $opponent_name = $opponent[0]['name'];
                        // $faction2 = $this->db->get_where('faction', array('id'=>$match['player2_faction']))->result_array();
                        $faction2 =$match['player1_faction'];
                        
                        if($match['status'] && $match['winner'] != '0') {
                            $winner = $this->db->get_where('user', array('id'=>$match['winner']))->result_array();
                            $winner_name = $winner[0]['name'];
                        }else{
                            $winner_name = 'None';
                        }
                        
                        
                        ?>
                        <tr>

                            <td><?php echo $match['id']; ?></td>
                            <td><?php echo $faction1; ?></td>
                            <td><?php echo $opponent_name; ?></td>
                            <td><?php echo $faction2; ?></td>
                            <td><?php echo $winner_name ?></td>
                            <td><?php echo $match['status']? 'Completed': 'In Progress'; ?></td>

                            <td>
                                <div class="bs-example">
                                    <div class="btn-group">
                                        <a href="<?php echo site_url('user/match_form/view/'.$match['id']); ?>" class="btn btn-info">
                                            <i class="entypo-pencil"></i>
                                            <?php echo get_phrase('view'); ?>
                                        </a>

                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>    
                </tbody>
                </table>
            </div>
        </div>
    </div><!-- end col-->
</div>

<script>
    $(document).ready(function () {
        var table1 = $('#match_table').DataTable({
            "scrollY": 600,
            "scrollX": true,
            "ordering": true,
            "paging": false,
            "info": false
        });

        table1.order( [ 0, 'desc' ] ).draw();
    });
</script>