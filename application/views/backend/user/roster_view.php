<?php
function unzip($src_file, $dest_dir=false, $create_zip_name_dir=true, $overwrite=true)
{

  $fstream = '';
  if ($zip = zip_open($src_file))
  {

    if ($zip)
    {
      $splitter = ($create_zip_name_dir === true) ? "." : "/";
//      if ($dest_dir === false) $dest_dir = substr($src_file, 0, strrpos($src_file, $splitter))."/";


      // Create the directories to the destination dir if they don't already exist
//      create_dirs($dest_dir);

      // For every file in the zip-packet
      while ($zip_entry = zip_read($zip))
      {

        // Now we're going to create the directories in the destination directories

        // If the file is not in the root dir
        $pos_last_slash = strrpos(zip_entry_name($zip_entry), "/");
//        if ($pos_last_slash !== false)
//        {
//          // Create the directory where the zip-entry should be saved (with a "/" at the end)
//          create_dirs($dest_dir.substr(zip_entry_name($zip_entry), 0, $pos_last_slash+1));
//        }

        // Open the entry
        if (zip_entry_open($zip,$zip_entry,"r"))
        {

//          // The name of the file to save on the disk
//          $file_name = $dest_dir.zip_entry_name($zip_entry);
//
//          // Check if the files should be overwritten or not
//          if ($overwrite === true || $overwrite === false && !is_file($file_name))
//          {
            // Get the content of the zip entry
            $fstream = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));



//          var_dump($forces);



//          print_r($obj->costs);
//          var_dump($fstream);

//            file_put_contents($file_name, $fstream );
//            // Set the rights
//            chmod($file_name, 0777);
//            return $file_name;

//          }

          // Close the entry
          zip_entry_close($zip_entry);
        }
      }
      // Close the zip-file
      zip_close($zip);
    }
  }
  else
  {
    return false;
  }

  return $fstream;
}


//function create_dirs($path)
//{
//  if (!is_dir($path))
//  {
//    $directory_path = "";
//    $directories = explode("/",$path);
//    array_pop($directories);
//
//    foreach($directories as $directory)
//    {
//      $directory_path .= $directory."/";
//      if (!is_dir($directory_path))
//      {
//        mkdir($directory_path);
//        chmod($directory_path, 0777);
//      }
//    }
//  }
//}
$roster = $roster->result_array();
$roster_name = $roster[0]['name'];

$roster_uri = '/uploads/rosters/'.$roster_name.'.zip';

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
