<?php


$roster = $roster->result_array();
$roster_name = $roster[0]['name'];

$roster_uri = '/uploads/rosters/'.$roster_name.'.rosz';

$res_file = unzip(dirname(BASEPATH).$roster_uri, false, true, true);


 ?>
 <div class="row">
   <div class="col-lg-12">
     <div class="panel panel-primary" data-collapsed="0">
       <div class="panel-heading">
         <div class="panel-title">
           <?php echo get_phrase('parse_roster_view'); ?>
         </div>

       </div>
       <div class="panel-body">
         <?php
         $obj = simplexml_load_string($res_file);

         $costs = $obj->costs->cost;

         foreach($costs as $cost){
           if($cost['name'] == 'pts') {
             ?>
               <p>Cost: <?php  echo $cost['value']; ?></p>
         <?php
           }
//
         }


         $forces = $obj->forces->force;
         foreach($forces as $force){
         ?>
         <p>Name: <?php echo $force['catalogueName'];?></p>
         <?php

         }

         ?>
       </div>
     </div>
   </div><!-- end col-->
 </div>
