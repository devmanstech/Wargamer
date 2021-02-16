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
                <li class="active"><a data-toggle="tab" href="#all">All</a></li>
                <li><a data-toggle="tab" href="#first">1000</a></li>
                <li><a data-toggle="tab" href="#second">2000</a></li>
            </ul>

            <div class="tab-content">
                <div id="all" class="tab-pane fade in active">
                    <table class=" faction_table" style="width:100%;font-size:14px">
                        <thead>
                        <tr>
                            <th style="text-align-last: center">Faction <br> (loss\win)</th>
                            <?php

                            $cols = array();
                            $rows = array();

                            foreach ($factions1 as $faction1) {

                                $this->db->where('player1_faction', $faction1['name']);

                                $player1 = $this->db->get('match')->result_array();

                                $this->db->where('player2_faction', $faction1['name']);

                                $player2 = $this->db->get('match')->result_array();

                                if(count($player1) + count($player2) >0){
                                    array_push($cols,$faction1['name']);

                                    ?>
                                    <th style="text-align-last: center"><?php echo $faction1['name'] ?></th>
                                    <?php

                                }



                            }

                            $rows = $cols;
                            ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($rows as $row) {
                            ?>
                            <tr>
                                <?php

                                echo '<td style="text-align-last: center">'.$row.'</td>';

                                foreach ($cols as $col) {
                                    $total = 0;
                                    $wins = 0;

                                    $this->db->where('player1_id=winner');
                                    $this->db->where('player1_faction', $col);
                                    $this->db->where('player2_faction', $row);

                                    $player1_wins = $this->db->get('match')->result_array();

                                    $this->db->where('player2_id=winner');
                                    $this->db->where('player2_faction', $col);
                                    $this->db->where('player1_faction', $row);

                                    $player2_wins = $this->db->get('match')->result_array();


                                    $this->db->where('player1_id=winner');
                                    $this->db->where('player1_faction', $row);
                                    $this->db->where('player2_faction', $col);

                                    $player2_loss = $this->db->get('match')->result_array();

                                    $this->db->where('player2_id=winner');
                                    $this->db->where('player1_faction', $col);
                                    $this->db->where('player2_faction', $row);

                                    $player1_loss = $this->db->get('match')->result_array();



                                    $total = count($player1_wins) + count($player1_loss) + count($player2_loss) + count($player2_wins);

                                    $wins = count($player1_wins) + count($player2_wins);


                                        if($total>0){
                                            echo '<td style="text-align-last: center">'.$wins*100/$total.'%</td>' ;
                                        }else{
                                            echo '<td style="text-align-last: center">-</td>' ;
                                        }

                                }
                                ?>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <div id="first" class="tab-pane fade in active" >
                    <table class=" faction_table" style="width:100%;font-size:14px">
                        <thead>
                        <tr>
                            <th style="text-align-last: center">Faction <br> (loss\win)</th>
                            <?php

                            $cols = array();
                            $rows = array();

                            foreach ($factions1 as $faction1) {

                                $this->db->where('player1_faction', $faction1['name']);

                                $player1 = $this->db->get('match')->result_array();

                                $this->db->where('player2_faction', $faction1['name']);

                                $player2 = $this->db->get('match')->result_array();

                                if(count($player1) + count($player2) >0){
                                    array_push($cols,$faction1['name']);

                                    ?>
                                    <th style="text-align-last: center"><?php echo $faction1['name'] ?></th>
                                    <?php

                                }



                            }

                            $rows = $cols;
                            ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($rows as $row) {
                            ?>
                            <tr>
                                <?php

                                echo '<td style="text-align-last: center">'.$row.'</td>';

                                foreach ($cols as $col) {
                                    $total = 0;
                                    $wins = 0;

                                    $this->db->where('player1_id=winner');
                                    $this->db->where('player1_faction', $col);
                                    $this->db->where('player2_faction', $row);
                                    $this->db->where('points', '0');

                                    $player1_wins = $this->db->get('match')->result_array();

                                    $this->db->where('player2_id=winner');
                                    $this->db->where('player2_faction', $col);
                                    $this->db->where('player1_faction', $row);
                                    $this->db->where('points', '0');

                                    $player2_wins = $this->db->get('match')->result_array();


                                    $this->db->where('player1_id=winner');
                                    $this->db->where('player1_faction', $row);
                                    $this->db->where('player2_faction', $col);
                                    $this->db->where('points', '0');

                                    $player2_loss = $this->db->get('match')->result_array();

                                    $this->db->where('player2_id=winner');
                                    $this->db->where('player1_faction', $col);
                                    $this->db->where('player2_faction', $row);
                                    $this->db->where('points', '0');

                                    $player1_loss = $this->db->get('match')->result_array();



                                    $total = count($player1_wins) + count($player1_loss) + count($player2_loss) + count($player2_wins);

                                    $wins = count($player1_wins) + count($player2_wins);


                                    if($total>0){
                                        echo '<td style="text-align-last: center">'.$wins*100/$total.'%</td>' ;
                                    }else{
                                        echo '<td style="text-align-last: center">-</td>' ;
                                    }

                                }
                                ?>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <div id="second" class="tab-pane fade in active">
                    <table class=" faction_table" style="width:100%;font-size:14px">
                        <thead>
                        <tr>
                            <th style="text-align-last: center">Faction <br> (loss\win)</th>
                            <?php

                            $cols = array();
                            $rows = array();

                            foreach ($factions1 as $faction1) {

                                $this->db->where('player1_faction', $faction1['name']);

                                $player1 = $this->db->get('match')->result_array();

                                $this->db->where('player2_faction', $faction1['name']);

                                $player2 = $this->db->get('match')->result_array();

                                if(count($player1) + count($player2) >0){
                                    array_push($cols,$faction1['name']);

                                    ?>
                                    <th style="text-align-last: center"><?php echo $faction1['name'] ?></th>
                                    <?php

                                }



                            }

                            $rows = $cols;
                            ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($rows as $row) {
                            ?>
                            <tr>
                                <?php

                                echo '<td style="text-align-last: center">'.$row.'</td>';

                                foreach ($cols as $col) {
                                    $total = 0;
                                    $wins = 0;

                                    $this->db->where('player1_id=winner');
                                    $this->db->where('player1_faction', $col);
                                    $this->db->where('player2_faction', $row);
                                    $this->db->where('points', '1');

                                    $player1_wins = $this->db->get('match')->result_array();

                                    $this->db->where('player2_id=winner');
                                    $this->db->where('player2_faction', $col);
                                    $this->db->where('player1_faction', $row);

                                    $this->db->where('points', '1');
                                    $player2_wins = $this->db->get('match')->result_array();


                                    $this->db->where('player1_id=winner');
                                    $this->db->where('player1_faction', $row);
                                    $this->db->where('player2_faction', $col);
                                    $this->db->where('points', '1');

                                    $player2_loss = $this->db->get('match')->result_array();

                                    $this->db->where('player2_id=winner');
                                    $this->db->where('player1_faction', $col);
                                    $this->db->where('player2_faction', $row);
                                    $this->db->where('points', '1');

                                    $player1_loss = $this->db->get('match')->result_array();



                                    $total = count($player1_wins) + count($player1_loss) + count($player2_loss) + count($player2_wins);

                                    $wins = count($player1_wins) + count($player2_wins);


                                    if($total>0){
                                        echo '<td style="text-align-last: center">'.$wins*100/$total.'%</td>' ;
                                    }else{
                                        echo '<td style="text-align-last: center">-</td>' ;
                                    }

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