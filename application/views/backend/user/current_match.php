
<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-primary" data-collapsed="0">
      <div class="panel-heading">
        <div class="panel-title">
          <?php echo get_phrase('current_match'); ?>
        </div>
      </div>
      <div class="panel-body">

        <button class="btn btn-danger" id="delete_listings" style="display: none;"><?php echo get_phrase('delete_selected'); ?></button>
      </div>
    </div>
  </div><!-- end col-->
</div>
<script type="text/javascript">
function filterTable() {
    $('#preloader_gif').show();
    update_date_range();
    var status = $('#status_filter').val();
    var agent = $('#agent_filter').val();
    var date_range = $('#date_range').val();

    $.ajax({
        type : 'POST',
        url : '<?php echo site_url('user/filter_listing_table'); ?>',
        data : {status : status, agent : agent, date_range : date_range},
        success : function(response){
            console.log(response);
            $('#listing_table').html(response);
            $('#preloader_gif').hide();
        }
    })
}

function update_date_range()
{
    var x = $("#selectedValue").html();
    $("#date_range").val(x);
}
</script>
<script>
//start multiple delete
$(document).ready(function() {
  $(".checkMark").click(function(){

    //for button hide and show
    var favorite = [];
    $.each($("input[name='listings_id']:checked"), function(){
      favorite.push($(this).val());
    });
    if(favorite != ''){
      $('#delete_listings').show();
      $('#delete_listings').animate({
        width: '200px'
      }, 300);

    }else{
      $('#delete_listings').animate({
        width: '130px'
      }, 300);
      $('#delete_listings').slideUp(80);
    }

    //for delete to database
    $('#delete_listings').click(function(){
      var vals = [];
      $(":checkbox").each(function() {
        if (this.checked)
        vals.push(this.value);
      });
      var listings_id = vals.toString();
      $.ajax({
        url: '<?php echo site_url('user/listings/listings_delete/'); ?>'+ listings_id,
        success: function(response){
          location.reload();
        }
      });
    });
  });
});
</script>
