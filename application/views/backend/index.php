<?php
$website_title = $this->db->get_where('settings' , array('type'=>'website_title'))->row()->description;
$user_details = $this->user_model->get_all_users($this->session->userdata('user_id'))->row_array();
$text_align     = $this->db->get_where('settings', array('type' => 'text_align'))->row()->description;
$logged_in_user_role = strtolower($this->session->userdata('role'));
?>

<!DOCTYPE html>
<html lang="en" dir="<?php if ($text_align == 'right-to-left') echo 'rtl';?>">
<head>

  <title><?php echo $page_title;?> | <?php echo $website_title;?></title>
  <!-- all the meta tags -->
  <?php include 'metas.php'; ?>
  <!-- all the css files -->
  <?php include 'includes_top.php';?>
  <?php include 'modal.php'; ?>
</head>
<body class="page-body" >
  <div class="page-container <?php if ($text_align == 'right-to-left') echo 'right-sidebar';?>" >
    <!-- SIDEBAR -->
    <?php include $logged_in_user_role.'/'.'navigation.php' ?>
    <div class="main-content">

      <!-- Topbar Start -->
      <?php include 'header.php'; ?>

      <?php
      if($logged_in_user_role == 'user'){
        ?>
        <div class="row">
          <div class="col-lg-8 col-md-8">
            <h3 style="margin:20px 0px;" class="hidden-print">

              <!-- Start Content-->
              <?php include $logged_in_user_role.'/'.$page_name.'.php';?>

            </h3>

          </div>

          <div class="col-lg-4 col-md-4">
            <h3 style="margin:20px 0px;" class="hidden-print">

              <!-- Search and Played games-->
              <?php include 'user/sidebar.php';?>

            </h3>
          </div>

        </div>

      <?php
      }else{
        ?>
        <h3 style="margin:20px 0px;" class="hidden-print">

          <!-- Start Content-->
          <?php include $logged_in_user_role.'/'.$page_name.'.php';?>

        </h3>


        <?php
      }
      ?>



      <!-- Footer starts here -->
      <?php include 'footer.php'; ?>
    </div>
  </div>
  <!-- all the js files -->
  <?php include 'includes_bottom.php'; ?>

  <?php include 'common_scripts.php'; ?>
</body>
</html>
