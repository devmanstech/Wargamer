<!-- <style>
    table {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        border: 1px solid #ddd;
    }

    th, td {
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2
    }

</style> -->
<?php
$factions1 = array();
$factions2 = array();
$factions1 = $this->db->get('faction')->result_array();
$factions2 = $this->db->get('faction')->result_array();

?>



<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <?php echo get_phrase('dashboard'); ?>
                </div>
            </div>
            <div class="panel-body">
            <ul class="nav nav-tabs justify-content-center">
                <li class="active"><a data-toggle="tab" href="#home">All</a></li>
                <li><a data-toggle="tab" href="#menu1">1000</a></li>
                <li><a data-toggle="tab" href="#menu2">2000</a></li>
            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                    <table class="cell-border  faction_table" style="width:100%;font-size:14px">
                        <thead class="cell-border">
                        <tr>
                            <th>Faction <br> (wins/total)</th>
                            <?php
                            foreach ($factions1 as $faction1) {
                                ?>
                                <th><?php echo $faction1['name'] ?></th>
                                <?php
                            }
                            ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($factions2 as $faction2) {
                            ?>
                            <tr>
                                <td><?php echo $faction2['name']; ?></td>
                                <?php
                                foreach ($factions1 as $faction1) {
                                    $total = 0;
                                    $wins = 0;
                                    $total = count(array_merge(
                                        $this->db->get_where('match', array('player1_id'=>$logged_in_user_id,'player1_faction'=>$faction2['name'], 'player2_faction'=>$faction1['name'], 'status'=>1))->result_array(),
                                        $this->db->get_where('match', array('player2_id'=>$logged_in_user_id,'player1_faction'=>$faction2['name'], 'player2_faction'=>$faction1['name'], 'status'=>1))->result_array()
                                    ));

                                    $wins = count(array_merge(
                                        $this->db->get_where('match', array('player1_id'=>$logged_in_user_id,'player1_faction'=>$faction2['name'], 'player2_faction'=>$faction1['name'], 'status'=>1, 'winner'=>$logged_in_user_id))->result_array(),
                                        $this->db->get_where('match', array('player2_id'=>$logged_in_user_id,'player1_faction'=>$faction2['name'], 'player2_faction'=>$faction1['name'], 'status'=>1, 'winner'=>$logged_in_user_id))->result_array()
                                    ));
                                    ?>
                                    <td style="text-align-last: center"><?php

                                        if($total>0){
                                            echo $wins*100/$total.'%' ;
                                        }else{
                                            echo '-';
                                        }
                                        ?></td>
                                    <?php
                                }
                                ?>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <div id="menu1" class="tab-pane fade">
                <table class="cell-border faction_table" style="width:100%;font-size:14px">
                        <thead class="cell-border">
                        <tr>
                            <th>Faction <br> (wins/total)</th>
                            <?php
                            foreach ($factions1 as $faction1) {
                                ?>
                                <th><?php echo $faction1['name'] ?></th>
                                <?php
                            }
                            ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($factions2 as $faction2) {
                            ?>
                            <tr>
                                <td><?php echo $faction2['name']; ?></td>
                                <?php
                                foreach ($factions1 as $faction1) {
                                    $total = 0;
                                    $wins = 0;
                                    $total = count(array_merge(
                                        $this->db->get_where('match', array('player1_id'=>$logged_in_user_id,'player1_faction'=>$faction2['name'], 'player2_faction'=>$faction1['name'], 'status'=>1, 'points'=>0))->result_array(),
                                        $this->db->get_where('match', array('player2_id'=>$logged_in_user_id,'player1_faction'=>$faction2['name'], 'player2_faction'=>$faction1['name'], 'status'=>1, 'points'=>0))->result_array()
                                    ));

                                    $wins = count(array_merge(
                                        $this->db->get_where('match', array('player1_id'=>$logged_in_user_id,'player1_faction'=>$faction2['name'], 'player2_faction'=>$faction1['name'], 'status'=>1, 'winner'=>$logged_in_user_id, 'points'=>0))->result_array(),
                                        $this->db->get_where('match', array('player2_id'=>$logged_in_user_id,'player1_faction'=>$faction2['name'], 'player2_faction'=>$faction1['name'], 'status'=>1, 'winner'=>$logged_in_user_id, 'points'=>0))->result_array()
                                    ));
                                    ?>
                                    <td style="text-align-last: center"><?php

                                        if($total>0){
                                            echo $wins*100/$total.'%' ;
                                        }else{
                                            echo '-';
                                        }
                                        ?></td>
                                    <?php
                                }
                                ?>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <div id="menu2" class="tab-pane fade">
                <table class="cell-border faction_table" style="width:100%;font-size:14px">
                        <thead class="cell-border">
                        <tr>
                            <th>Faction <br> (wins/total)</th>
                            <?php
                            foreach ($factions1 as $faction1) {
                                ?>
                                <th><?php echo $faction1['name'] ?></th>
                                <?php
                            }
                            ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($factions2 as $faction2) {
                            ?>
                            <tr>
                                <td><?php echo $faction2['name']; ?></td>
                                <?php
                                foreach ($factions1 as $faction1) {
                                    $total = 0;
                                    $wins = 0;
                                    $total = count(array_merge(
                                        $this->db->get_where('match', array('player1_id'=>$logged_in_user_id,'player1_faction'=>$faction2['name'], 'player2_faction'=>$faction1['name'], 'status'=>1, 'points'=>1))->result_array(),
                                        $this->db->get_where('match', array('player2_id'=>$logged_in_user_id,'player1_faction'=>$faction2['name'], 'player2_faction'=>$faction1['name'], 'status'=>1, 'points'=>1))->result_array()
                                    ));

                                    $wins = count(array_merge(
                                        $this->db->get_where('match', array('player1_id'=>$logged_in_user_id,'player1_faction'=>$faction2['name'], 'player2_faction'=>$faction1['name'], 'status'=>1, 'winner'=>$logged_in_user_id, 'points'=>1))->result_array(),
                                        $this->db->get_where('match', array('player2_id'=>$logged_in_user_id,'player1_faction'=>$faction2['name'], 'player2_faction'=>$faction1['name'], 'status'=>1, 'winner'=>$logged_in_user_id, 'points'=>1))->result_array()
                                    ));
                                    ?>
                                    <td style="text-align-last: center"><?php

                                        if($total>0){
                                            echo $wins*100/$total.'%' ;
                                        }else{
                                            echo '-';
                                        }
                                        ?></td>
                                    <?php
                                }
                                ?>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div><!-- end col-->
</div>

<script>
    $(document).ready(function () {
        $('.faction_table').DataTable({
            "scrollY": 600,
            "scrollX": true,
            "ordering": false,
            "paging": false,
            "info": false
        });
    });
</script>