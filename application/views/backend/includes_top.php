<link rel="shortcut icon" href="<?php echo base_url();?>assets/global/favicon.png">
<!-- Neon theme css -->
<link rel="stylesheet" href="<?php echo base_url('assets/backend/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css');?>" type="text/css">
<link rel="stylesheet" href="<?php echo base_url('assets/backend/css/font-icons/entypo/css/entypo.css');?>" type="text/css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600" type="text/css">
<link rel="stylesheet" href="<?php echo base_url('assets/backend/css/bootstrap.css');?>" type="text/css">
<link rel="stylesheet" href="<?php echo base_url('assets/backend/css/neon-core.css');?>" type="text/css">
<link rel="stylesheet" href="<?php echo base_url('assets/backend/css/neon-theme.css');?>" type="text/css">
<link rel="stylesheet" href="<?php echo base_url('assets/backend/css/neon-forms.css');?>" type="text/css">
<link rel="stylesheet" href="<?php echo base_url('assets/backend/css/custom.css');?>" type="text/css">
<link rel="stylesheet" href="<?php echo base_url('assets/backend/js/vertical-timeline/css/component.css');?>" type="text/css">
<link rel="stylesheet" href="<?php echo base_url('assets/backend/js/datatable/css/dataTables.bootstrap.css');?>" type="text/css"/>
<link rel="stylesheet" href="<?php echo base_url('assets/backend/js/datatable/buttons/css/buttons.bootstrap.css');?>" type="text/css"/>
<link rel="stylesheet" href="<?php echo base_url('assets/backend/js/wysihtml5/bootstrap-wysihtml5.css');?>" type="text/css">
<link rel="stylesheet" href="<?php echo base_url('assets/backend/js/dropzone/dropzone.css');?>" type="text/css">
<link rel="stylesheet" href="<?php echo base_url('assets/backend/js/daterangepicker/daterangepicker-bs3.css');?>" type="text/css">
<!-- font awesome 5 -->
<link href="<?php echo base_url('assets/backend/css/fontawesome-all.min.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/backend/css/font-awesome-icon-picker/fontawesome-iconpicker.min.css') ?>" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
<link href="<?php echo base_url('assets/backend/css/main.css') ?>" rel="stylesheet" type="text/css" />

<!--data table-->
<link href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />

<!-- RTL Theme -->
<?php if ($text_align == 'right-to-left') : ?>
    <link rel="stylesheet" href="<?php echo base_url('assets/backend/css/neon-rtl.css');?>">
<?php endif; ?>
<script src="<?php echo base_url('assets/backend/js/jquery-2.2.4.min.js'); ?>" charset="utf-8"></script>
<!-- AM Chart resources -->
<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js">

<?php


function get_select_html($selected = '')
{

    $secondaries = $this->db->get('secondary')->result_array();


    $select_html = '';

    foreach ($secondaries as $secondary) {
        if ($selected == $secondary['id']) {
            $select_html .= '<option value="' . $secondary['id'] . '" selected>' . $secondary['name'] . '</option>';
        } else {
            $select_html .= '<option value="' . $secondary['id'] . '">' . $secondary['name'] . '</option>';
        }

    }

    return $select_html;
}




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

                    $fstream = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

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

?>