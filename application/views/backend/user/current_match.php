<?php

$match_id = ($this->db->get_where('current_match', array('user_id' => $logged_in_user_id))->result_array())[0]['match_id'];

$secondaries = $this->db->get('secondary')->result_array();

if($match_id){
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
                    <?php echo get_phrase('current_match'), " : ", $match_id; ?>
                    <span style="float:right">Points : <?php echo $points == '0' ? 'Under 1000' : 'Above 1000' ?></span>
                </div>
            </div>
            <div class="panel-body">

                <div class="col-md-12">
                    <div class="row" style="margin-bottom: 15px;">
                        <div class="col-lg-6 col-md-12">
                            <span style="font-size:20px; color:blue">Created : </span>
                            <span><?php echo $diff->format("%H hours %I min") ?> ago</span>
                        </div>
                        <div class="col-lg-6 col-md-12">
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

                                <form action="<?php echo site_url('user/current_match/save/' . $logged_in_user_id); ?>"
                                      method="post" enctype="multipart/form-data" role="form"
                                      class="form-horizontal  match_add_form">
                                    <label>Primary Score : </label>
                                    <input type="number" max="45" class="form-control" name="score" id="score"
                                           value="<?php echo $score ?>"
                                           placeholder="<?php echo get_phrase('enter_score'); ?>" required>

                                    <label>Secondary Scores : </label>

                                    <?php

                                    $your_scores = json_decode($your_secondary_scores);

                                    foreach ($your_scores as $key => $your_score) {

                                        ?>
                                        <div style="margin-bottom: 10px;margin-top: 10px" class="row" id="inputFormRow">
                                            <div class="col-sm-12" style="margin-bottom: 5px"><select
                                                    name="secondary_name[]" class="inline form-control">
                                                    <?php


                                                    $select_html = '';

                                                    foreach ($secondaries as $secondary) {
                                                        if ($key == $secondary['id']) {
                                                            $select_html .= '<option value="' . $secondary['id'] . '" selected>' . $secondary['name'] . '</option>';
                                                        } else {
                                                            $select_html .= '<option value="' . $secondary['id'] . '">' . $secondary['name'] . '</option>';
                                                        }

                                                    }


                                                    echo $select_html;
                                                    ?>
                                                </select></div>
                                            <div class="col-sm-9"><input max="15" type="number" name="secondary_score[]"
                                                                         class="inline form-control"
                                                                         value="<?php echo $your_score ?>"
                                                                         placeholder="Enter points" autocomplete="off">
                                            </div>
                                            <div class="col-sm-3">
                                                <button id="removeRow" type="button"
                                                        class="inline btn btn-danger pull-right">Remove
                                                </button>
                                            </div>
                                        </div>
                                        <?php
                                    }

                                    ?>

                                    <div id="newRow"></div>
                                    <div class="form-group">
                                        <button id="addRow" type="button" class="btn btn-outline-secondary pull-right">
                                            Add Secondary
                                        </button>
                                    </div>


                                    <label>Comment : </label>
                                    <textarea class="form-control" name="comment"
                                              id="comment"><?php echo $comment ?></textarea>
                                    <input type="checkbox" id="agree_status"
                                           name="agree_status" <?php echo $agree_status ? 'checked' : '' ?>/>
                                    <label for="agree_status">Do you agree with result? </label>
                                    <input type="hidden" name="match_id" id="match_id" value="<?php echo $match_id ?>"/>
                                    <input type="hidden" name="user_id" id="user_id"
                                           value="<?php echo $logged_in_user_id ?>"/>
                                    <button style="margin-top:5px;float:right" type="submit" class="btn btn-info">Save
                                    </button>

                                </form>
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

    <script>
        var secondary_total = JSON.parse('<?php echo json_encode($secondaries) ?>');

        function get_secondary_by_id(id){

            $.each(secondary_total, function(key, value){

                if(value['id'] == id) return value['name'];
            });

        }

    </script>

    <?php
    if ($status == 0) {
        ?>
        <script>

            var ajax_call_for_status = function () {

                $.post("/user/current_match/check/<?php echo $match_id ?>/<?php echo $opponent_id ?>", {},
                    function (data) {

                        if (data) {
                            var res = JSON.parse(data);
                            var score = res.score;
                            var comment = res.comment;
                            var agree_status = res.agree_status;
                            var secondary = res.secondary;
                            var html = res.html;

                            $('#opponent_score').val(score);
                            var secondary_html = '';
                            $.each(secondary, function(key, value) {
                                secondary_html += '<label>' +secondary_total[key-1]['name'] + ' </label>' +
                                    '<input type="number" max="45" class="form-control" value="' + value + '"' +
                                    'disabled>';
                            });
                            $('#secondary_scores').html(secondary_html);

                            $('#opponent_comment').html(comment);
                            // $('#opponent_agree_status').attr('checked' ,agree_status == 1 ? 'checked' : '');
                            $('#opponent_agree_status').prop('checked', agree_status == '0' ? false : true);

                            $('#finish_button_container').html(html);
                            // document.location.href="/user/current_match/"+data;
                        }
                    }
                );

            };

            var interval = 5000; // check search status per 3min

            setInterval(ajax_call_for_status, interval);

        </script>

        <?php
    }
    ?>

    <?php
    } else {
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


    <script type="text/javascript">
        // add row
        $("#addRow").click(function () {
            var html = '';
            html += '<div style="margin-bottom: 10px;margin-top: 10px" class="row" id="inputFormRow">';
            html += '<div class="col-sm-12" style="margin-bottom: 5px">';
            html += '<select name="secondary_name[]" class="inline form-control">' +
                '<option value="0">Please choose secondary</option>' + '<?php
                $select_html = '';
                foreach ($secondaries as $secondary) {
                    $select_html .= '<option value="' . $secondary['id'] . '">' . $secondary['name'] . '</option>';
                }
                echo $select_html;
                ?>' + '</select>';
            html += '</div>';
            html += '<div class="col-sm-9">';
            html += '<input max="15" type="number" name="secondary_score[]" class="inline form-control" placeholder="Enter points" autocomplete="off">';
            html += '</div>';
            html += '<div class="col-sm-3">';
            html += '<button id="removeRow" type="button" class="inline btn btn-danger pull-right">Remove</button>';
            html += '</div>';
            html += '</div>';

            $('#newRow').append(html);
        });

        // remove row
        $(document).on('click', '#removeRow', function () {
            $(this).closest('#inputFormRow').remove();
        });
    </script>
