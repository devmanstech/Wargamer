<?php


$secondaries = $this->db->get('secondary')->result_array();


    $match = $this->db->get_where('match', array('id' => $match_id))->result_array();
    $current_match = $match[0];
    $created_date = new DateTime($current_match['created_at']);
    $date = new DateTime('now');
    $diff = $created_date->diff($date);
    $status = $current_match['status'];
    $points = $current_match['points'];
    if ($current_match['player1_id'] == $logged_in_user_id) {
        $your_faction = $current_match['player1_faction'];
        $you = ($this->db->get_where('user', array('id' => $current_match['player1_id']))->result_array())[0];
        $your_name = $you['name'];
        $your_roster_id = $current_match['player1_roster_id'];
        $your_roster_filename = ($this->db->get_where('roster', array('id' => $your_roster_id))->result_array())[0]['name'];
        $your_roster_url = base_url() . 'uploads/rosters/' . $your_roster_filename . '.zip';

        $your_secondary_scores = $current_match['player1_secondary_score'];

        $opponent_id = $current_match['player2_id'];
        $opponent_faction = $current_match['player2_faction'];
        $opponent = ($this->db->get_where('user', array('id' => $current_match['player2_id']))->result_array())[0];
        $opponent_name = $opponent['name'];
        $opponent_roster_id = $current_match['player2_roster_id'];
        $opponent_roster_filename = ($this->db->get_where('roster', array('id' => $opponent_roster_id))->result_array())[0]['name'];
        $opponent_roster_url = base_url() . 'uploads/rosters/' . $opponent_roster_filename . '.zip';

        $opponent_secondary_scores = $current_match['player2_secondary_score'];

        $score = $current_match['player1_score'];
        $comment = $current_match['player1_comment'];
        $agree_status = $current_match['player1_agree_status'];
        $opponent_score = $current_match['player2_score'];
        $opponent_comment = $current_match['player2_comment'];
        $opponent_agree_status = $current_match['player2_agree_status'];
    } else {
        $your_faction = $current_match['player2_faction'];
        $you = ($this->db->get_where('user', array('id' => $current_match['player2_id']))->result_array())[0];
        $your_name = $you['name'];
        $your_roster_id = $current_match['player2_roster_id'];
        $your_roster_filename = ($this->db->get_where('roster', array('id' => $your_roster_id))->result_array())[0]['name'];
        $your_roster_url = base_url() . 'uploads/rosters/' . $your_roster_filename . '.zip';

        $your_secondary_scores = $current_match['player2_secondary_score'];

        $opponent_id = $current_match['player1_id'];
        $opponent_faction = $current_match['player1_faction'];
        $opponent = ($this->db->get_where('user', array('id' => $current_match['player1_id']))->result_array())[0];
        $opponent_name = $opponent['name'];
        $opponent_roster_id = $current_match['player1_roster_id'];
        $opponent_roster_filename = ($this->db->get_where('roster', array('id' => $opponent_roster_id))->result_array())[0]['name'];
        $opponent_roster_url = base_url() . 'uploads/rosters/' . $opponent_roster_filename . '.zip';

        $opponent_secondary_scores = $current_match['player1_secondary_score'];

        $score = $current_match['player2_score'];
        $comment = $current_match['player2_comment'];
        $agree_status = $current_match['player2_agree_status'];
        $opponent_score = $current_match['player1_score'];
        $opponent_comment = $current_match['player1_comment'];
        $opponent_agree_status = $current_match['player1_agree_status'];


    }

    ?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <?php echo get_phrase('match'), " : ", $match_id; ?>
                    <span style="float:right">Points : <?php echo $points == '0' ? 'Under 1000' : 'Above 1000' ?></span>
                </div>
            </div>
            <div class="panel-body">

                <div class="col-md-12">
                    <div class="row" style="margin-bottom: 15px;">

                        <div class="col-lg-12 col-md-12">
                            <a class="btn btn-warning"
                               style="float:right"><?php echo $status ? 'Completed' : 'In progress' ?></a>

                        </div>


                    </div>

                    <div class="col-md-12">

                        <div class="row" style="margin-bottom: 15px;">
                            <div class="col-lg-6 col-md-12">
                                <span style="font-size:20px; color:blue"><?php echo get_phrase('you') ?></span>
                                <hr>
                                <p>
                                    <label>Name : </label> <?php echo $your_name ?>
                                </p>

                                <p>
                                    <label>Faction : </label> <?php echo $your_faction ?>
                                </p>

                                <p>
                                    <label>Roster : </label> <a style="color:blue;text-decoration-line:underline"
                                                                href="<?php echo $your_roster_url ?>"><?php echo $your_roster_filename ?> </a>
                                </p>


                                    <label>Primary Score : </label>
                                    <input type="number" max="45" class="form-control" name="score" id="score"
                                           value="<?php echo $score ?>"
                                           placeholder="<?php echo get_phrase('enter_score'); ?>" disabled>

                                    <label>Scondary Scores : </label>
                                    <div id="secondary_scores">
                                        <?php

                                        $your_scores = json_decode($your_secondary_scores);

                                        foreach ($your_scores as $key => $your_score) {


                                            $secondary_name = $this->db->get_where('secondary', array('id'=>$key))->row('name');
                                            ?>
                                            <label><?php echo $secondary_name ?> </label>
                                            <input type="number" max="45" class="form-control" value="<?php echo $your_score ?>" disabled>
                                            <?php
                                        }

                                        ?>
                                    </div>

                                    <label>Comment : </label>
                                    <textarea class="form-control" name="comment"
                                              id="comment" disabled><?php echo $comment ?></textarea>
                                    <input type="checkbox" id="agree_status"
                                           name="agree_status" <?php echo $agree_status ? 'checked' : '' ?> disabled/>
                                    <label for="agree_status">You agreed? </label>


                                <br>
                            </div>

                            <div class="col-lg-6 col-md-12">
                                <span style="font-size:20px; color:blue"><?php echo get_phrase('opponent'); ?></span>
                                <hr>
                                <p><label>Name : </label> <?php echo $opponent_name ?></p>

                                <p><label>Faction : </label> <?php echo $opponent_faction ?></p>

                                <p>
                                    <label>Roster : </label> <a style="color:blue;text-decoration-line:underline"
                                                                href="<?php echo $opponent_roster_url ?>"><?php echo $opponent_roster_filename ?> </a>
                                </p>

                                <label>Primary Score : </label>
                                <input type="number" max="45" class="form-control" value="<?php echo $opponent_score ?>"
                                       id="opponent_score" placeholder="<?php echo get_phrase('opponent_score'); ?>"
                                       disabled>

                                <label>Scondary Scores : </label>
                                <div id="secondary_scores">
                                    <?php

                                    $opponent_scores = json_decode($opponent_secondary_scores);

                                    foreach ($opponent_scores as $key => $opponent_score) {


                                        $secondary_name = $this->db->get_where('secondary', array('id'=>$key))->row('name');
                                        ?>
                                        <label><?php echo $secondary_name ?> </label>
                                        <input type="number" max="45" class="form-control" value="<?php echo $opponent_score ?>" disabled>
                                        <?php
                                    }

                                    ?>
                                </div>
                                <label>Comment : </label>
                                <textarea class="form-control" id="opponent_comment"
                                          disabled> <?php echo $opponent_comment ?> </textarea>
                                <input type="checkbox" id="opponent_agree_status"
                                    <?php echo $opponent_agree_status == '1' ? 'checked' : '' ?>  disabled/>
                                <label>Opponent agreed? </label>

                            </div>

                        </div>
                    </div>
                    <div id="finish_button_container">
                    </div>


                </div>

            </div>

        </div><!-- end col-->
    </div>

