<?php
$queue = $this->db->get_where('queue', array('user_id' => $logged_in_user_id, 'status' => 1))->result_array();
if (count($queue) > 0) $search_status = 1;
$search_create_at = $queue[0]['create_at'];
$date = new DateTime('now');
$server_time = $date->format('Y-m-d H:i:s');

$current_match = $this->db->get_where('current_match', array('user_id' => $logged_in_user_id))->row();
$current_match_status = $this->db->get_where('match', array('id' => $current_match->match_id))->row('status');

?>

<style>
    .countup {
        text-align: center;
        margin-bottom: 20px;
    }

    .countup .timeel {
        display: inline-block;
        padding: 10px;
        background: #151515;
        margin: 0;
        color: white;
        min-width: 2.6rem;
        margin-left: 13px;
        border-radius: 10px 0 0 10px;
    }

    .countup span[class*="timeRef"] {
        border-radius: 0 10px 10px 0;
        margin-left: 0;
        background: #e8c152;
        color: black;
    }
</style>

<div class="panel-primary">

    <?php
    if ($current_match == null || $current_match_status != '0') {
        ?>
        <div class="row" style="text-align-last:center">
            <div class="col-lg-12" style="padding-top: 20px">

                <?php

                if ($search_status) {
                    ?>


                    <div class="countup" id="countup1">
                        <span class="timeel hours">00</span>
                        <span class="timeel timeRefHours">h</span>
                        <span class="timeel minutes">00</span>
                        <span class="timeel timeRefMinutes">m</span>
                        <span class="timeel seconds">00</span>
                        <span class="timeel timeRefSeconds">s</span>
                    </div>

                    <a href="<?php echo site_url('user/search/stop/' . $logged_in_user_id) ?>" class="btn btn-info"
                       style="width: 80%">

                        <i class="fas fa-spinner fa-pulse"></i>
                        Search Stop
                    </a>
                    <?php
                } else {
                    ?>
                    <a href="<?php echo site_url('user/search/start') ?>" class="btn btn-info" style="width: 80%">

                        <i class="fa fa-search"></i>
                        Search Start
                    </a>
                    <?php
                }
                ?>


            </div>
        </div>

        <hr>

        <?php
    }
    ?>
    <div class="row" style="padding: 20px">
    <div class="panel" style="text-align-last: center;padding: 20px">
        <p>
            Support us to develop better tools and organize events to attract events for underplayed factions
        </p>
        <a href="https://www.patreon.com/bePatron?u=50354709" data-patreon-widget-type="become-patron-button">Become a Patron!</a>
    </div>
    </div>

    <hr>

    <div class="row" style="padding: 20px">

        <p style="text-align-last:center;font-size:20px; color:blue">Games Played Today</p>


        <?php
        $date = new DateTime('now');
        $search = $date->format('Y-m-d');
        $this->db->where('player1_id', $logged_in_user_id);
        $this->db->like('finished_at', $search);
        $today_games1 = $this->db->get('match')->result_array();

        $this->db->where('player2_id', $logged_in_user_id);
        $this->db->like('finished_at', $search);
        $today_games2 = $this->db->get('match')->result_array();
        ?>

        <?php

        if (count($today_games1) + count($today_games2) > 0) {
            foreach ($today_games1 as $today_game) {
                ?>

                <div class="panel" style="margin-bottom:5px;padding: 20px">
                    <div class="panel-header" style="text-align-last:center">
                        <?php echo $today_game['player1_faction'] . ":" . $today_game['player2_faction'] ?>
                    </div>
                    <hr>
                    <p>
                        <span>Points: <?php
                            if($today_game['points'] == '0'){
                                echo '1000';
                            }else{
                                echo '2000';
                            }
                            ?> </span>

                        <?php
                        if($today_game['winner'] == $logged_in_user_id){?>
                            <span class="label label-success pull-right"><i class="far fa-thumbs-up "></i> </span>
                            <?php
                        }else if($today_game['winner'] == '0'){
                            ?>
                            <span class="label label-warning pull-right"><i class="far fa-hand-paper "></i> </span>
                            <?php
                        }else{
                            ?>
                            <span class="label label-danger pull-right"><i class="far fa-thumbs-down "></i> </span>
                            <?php
                        }
                        ?>


                    </p>
                </div>
            <?php
            }


            foreach ($today_games2 as $today_game) {
                ?>

                <div class="panel" style="margin-bottom:5px;padding: 20px">
                    <div class="panel-header" style="text-align-last:center">
                        <?php echo $today_game['player2_faction'] . ":" . $today_game['player1_faction'] ?>
                    </div>
                    <hr>
                    <p>
                        <span>Points: <?php
                            if($today_game['points'] == '0'){
                                echo '1000';
                            }else{
                                echo '2000';
                            }
                            ?> </span>

                        <?php
                        if($today_game['winner'] == $logged_in_user_id){?>
                            <span class="label label-success pull-right"><i class="far fa-thumbs-up "></i> </span>
                            <?php
                        }else if($today_game['winner'] == '0'){
                            ?>
                            <span class="label label-warning pull-right"><i class="far fa-hand-paper "></i> </span>
                            <?php
                        }else{
                            ?>
                            <span class="label label-danger pull-right"><i class="far fa-thumbs-down "></i> </span>
                            <?php
                        }
                        ?>
                    </p>
                </div>
                <?php
            }
            ?>

            <?php
        } else {
            ?>
            <div class="column" style="text-align-last: center">
                <small >
                    There is not any game played today.
                </small>
            </div>

            <?php
        }
        ?>


    </div>

</div>


    <script async src="https://c6.patreon.com/becomePatronButton.bundle.js"></script>

<?php
if ($search_status) {
    ?>


    <script>

        window.onload = function () {
// Month Day, Year Hour:Minute:Second, id-of-element-container
            var create_at = '<?php echo $search_create_at?>';
            var server_time = '<?php echo $server_time ?>';
            server_time = new Date(server_time).getTime();

            create_at = new Date(create_at).getTime();

            var now = new Date().getTime();

            var countfrom = create_at + now - server_time;

            countUpFromTime(countfrom, 'countup1'); // ****** Change this line!
        };
        function countUpFromTime(countFrom, id) {

            var now = new Date(),
                countFrom = new Date(countFrom),
                timeDifference = (now - countFrom);

            var secondsInADay = 60 * 60 * 1000 * 24,
                secondsInAHour = 60 * 60 * 1000;

            days = Math.floor(timeDifference / (secondsInADay) * 1);
            hours = Math.floor((timeDifference % (secondsInADay)) / (secondsInAHour) * 1);
            mins = Math.floor(((timeDifference % (secondsInADay)) % (secondsInAHour)) / (60 * 1000) * 1);
            secs = Math.floor((((timeDifference % (secondsInADay)) % (secondsInAHour)) % (60 * 1000)) / 1000 * 1);

            var idEl = document.getElementById(id);
            idEl.getElementsByClassName('hours')[0].innerHTML = hours;
            idEl.getElementsByClassName('minutes')[0].innerHTML = mins;
            idEl.getElementsByClassName('seconds')[0].innerHTML = secs;

            clearTimeout(countUpFromTime.interval);
            countUpFromTime.interval = setTimeout(function () {
                countUpFromTime(countFrom, id);
            }, 1000);
        }

        var ajax_call = function () {
//   console.log('ok')
            $.post("/user/search/check/<?php echo $logged_in_user_id ?>", {},
                function (data) {
                    if (data) {
                        document.location.href = "/user/current_match/" + data;
                    }
                }
            );

        };

        var interval = 2000; // check search status per 3min

        setInterval(ajax_call, interval);

    </script>

    <?php
}
?>
