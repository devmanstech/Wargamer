<?php 
$rosters = $this->db->get_where('roster', array('user_id'=>$logged_in_user_id));
?>

<div class="row ">
    <div class="col-lg-12">
        <a href="<?php echo site_url('user/roster_form/add'); ?>" class="btn btn-primary alignToTitle"><i class="entypo-plus"></i><?php echo get_phrase('roster_add'); ?></a>
    </div><!-- end col-->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title">
					<?php echo get_phrase('general_roster_list'); ?>
				</div>
			</div>
			<div class="panel-body">
                <table id="roster_table" style="font-size:14px">
                	<thead>
                		<tr>
                			<th width="20"><div>#</div></th>

                			<th width="30%"><div><?php echo get_phrase('name');?></div></th>
                            <th width="10%"><div><?php echo get_phrase('points');?></div></th>
                            <th width="30%"><div><?php echo get_phrase('faction');?></div></th>
                			<th><div><?php echo get_phrase('option');?></div></th>
                		</tr>
                	</thead>
                	<tbody>
                        <?php
                         $counter = 0;
                         foreach ($rosters->result_array() as $roster): ?>
                            <tr>
                                <td><?php echo ++$counter; ?></td>

                                <td><?php echo $roster['name']; ?></td>
                                <td><?php echo $roster['cost']; ?></td>
                                <td><?php echo $roster['catalogue_name']; ?></td>

                                <td>
                                    <div class="bs-example">
                                     
                                     
                                         
                                                <a href="<?php echo site_url('user/roster_form/view/'.$roster['id']); ?>" class="btn btn-info">
                                                    <i class="entypo-pencil"></i>
                                                    <?php echo get_phrase('view'); ?>
                                                </a>
                                     
                                            <a href="#" class="btn btn-danger" onclick="confirm_modal('<?php echo site_url('user/rosters/delete/'.$roster['id']); ?>');">
                                                <i class="entypo-trash"></i>
                                                <?php echo get_phrase('delete'); ?>
                                            </a>
                                     
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                	</tbody>
                </table>
			</div>
		</div>
	</div><!-- end col-->
</div>

<script>
    $(document).ready(function () {
        $('#roster_table').DataTable({            
            "scrollX": true,
            "ordering": false,
            "paging": false,
            "info": false
        });
    });
</script>