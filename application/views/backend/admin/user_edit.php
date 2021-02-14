<?php
    $user_details = $this->user_model->get_all_users($user_id)->row_array();
    $social_links = json_decode($user_details['social'], true);
 ?>
 <div class="row">
   <div class="col-lg-12">
     <div class="panel panel-primary" data-collapsed="0">
       <div class="panel-heading">
         <div class="panel-title">
           <?php echo get_phrase('user_add_form'); ?>
         </div>
       </div>
       <div class="panel-body">
         <form action="<?php echo site_url('admin/users/edit/'.$user_id); ?>" method="post" enctype="multipart/form-data" role="form" class="form-horizontal form-groups-bordered">
           <div class="form-group">
             <label for="name" class="col-sm-3 control-label"><?php echo get_phrase('name'); ?></label>
             <div class="col-sm-7">
               <input type="text" class="form-control" name="name" id="name" placeholder="<?php echo get_phrase('name'); ?>" value="<?php echo $user_details['name']; ?>" required>
             </div>
           </div>
           <div class="form-group">
             <label for="email" class="col-sm-3 control-label"><?php echo get_phrase('email'); ?></label>
             <div class="col-sm-7">
               <input type="email" class="form-control" name="email" id="email" placeholder="<?php echo get_phrase('email'); ?>" value="<?php echo $user_details['email']; ?>" required>
             </div>
           </div>
           
           <div class="col-sm-offset-3 col-sm-5" style="padding-top: 10px;">
             <button type="submit" class="btn btn-info"><?php echo get_phrase('update_user'); ?></button>
           </div>
         </form>
       </div>
     </div>
   </div><!-- end col-->
 </div>
