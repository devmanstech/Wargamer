<?php
$queue = $this->db->get_where('queue',array('user_id'=> $logged_in_user_id, 'status'=>1))->result_array();
if(count($queue)>0) $search_status = 1;
$search_create_at = $queue[0]['create_at'];
$date = new DateTime('now');
$server_time = $date->format('Y-m-d H:i:s');

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



<div class="panel-primary" style="text-align-last: center;vertical-align: middle">
    <div class="row">
        <div class="col-lg-12" style="padding-top: 20px">

            <?php

            if($search_status){
                ?>

               
                    <div class="countup" id="countup1">
                    <span class="timeel hours">00</span>
                    <span class="timeel timeRefHours">h</span>
                    <span class="timeel minutes">00</span>
                    <span class="timeel timeRefMinutes">m</span>
                    <span class="timeel seconds">00</span>
                    <span class="timeel timeRefSeconds">s</span>
                </div>

                <a href="<?php echo site_url('user/search/stop/'.$logged_in_user_id) ?>" class="btn btn-info" style="width: 80%">

                        <i class="fas fa-spinner fa-pulse"></i>
                    Search Stop
                </a>
            <?php
            }else{
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


    <div class="row" style="padding-bottom: 20px">
        <div class="column">
            <span>Games Played Today</span>
        </div>


        <div class="column">
            <img src="../../../../assets/backend/images/admin.png" width="30px">
            <img src="../../../../assets/backend/images/admin.png" width="30px">
            <img src="../../../../assets/backend/images/admin.png" width="30px">
            <img src="../../../../assets/backend/images/admin.png" width="30px">
            <img src="../../../../assets/backend/images/admin.png" width="30px">
        </div>
        <div class="column">
            <img src="../../../../assets/backend/images/admin.png" width="30px">
            <img src="../../../../assets/backend/images/admin.png" width="30px">
            <img src="../../../../assets/backend/images/admin.png" width="30px">
            <img src="../../../../assets/backend/images/admin.png" width="30px">
            <img src="../../../../assets/backend/images/admin.png" width="30px">
        </div>
        <div class="column">
            <img src="../../../../assets/backend/images/admin.png" width="30px">
            <img src="../../../../assets/backend/images/admin.png" width="30px">
            <img src="../../../../assets/backend/images/admin.png" width="30px">
            <img src="../../../../assets/backend/images/admin.png" width="30px">
            <img src="../../../../assets/backend/images/admin.png" width="30px">
        </div>
        <div class="column">
            <img src="../../../../assets/backend/images/admin.png" width="30px">
            <img src="../../../../assets/backend/images/admin.png" width="30px">
            <img src="../../../../assets/backend/images/admin.png" width="30px">
            <img src="../../../../assets/backend/images/admin.png" width="30px">
            <img src="../../../../assets/backend/images/admin.png" width="30px">
        </div>
    </div>

</div>

<?php
if($search_status){
    ?>


<script>

window.onload = function() {
// Month Day, Year Hour:Minute:Second, id-of-element-container
    var create_at = '<?php echo $search_create_at?>';
    var server_time = '<?php echo $server_time ?>';
    server_time = new Date(server_time).getTime();

    create_at = new Date(create_at).getTime();

    var now = new Date().getTime();

    var countfrom =create_at +   now - server_time;

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
    countUpFromTime.interval = setTimeout(function(){ countUpFromTime(countFrom, id); }, 1000);
}

var ajax_call = function() {
//   console.log('ok')
$.post("/user/search/check/<?php echo $logged_in_user_id ?>", {
			
			},
			function (data) {
                if(data){
                    document.location.href="/user/current_match/"+data;
                }
			}
		);

};

var interval = 1000*60*3 ; // check search status per 3min

setInterval(ajax_call, interval);

</script>

<?php
}
?>
