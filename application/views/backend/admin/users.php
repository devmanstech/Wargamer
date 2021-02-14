<div class="row ">
    <div class="col-lg-12">
        <a href="<?php echo site_url('admin/user_form/add'); ?>" class="btn btn-primary alignToTitle"><i class="entypo-plus"></i><?php echo get_phrase('add_new_user'); ?></a>
    </div><!-- end col-->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title">
					<?php echo get_phrase('general_user_list'); ?>
				</div>
			</div>
			<div class="panel-body">
                <table id="user_table" style="font-size:14px" >
                	<thead>
                		<tr>
                			<th width="80"><div>#</div></th>
                			
                			<th><div><?php echo get_phrase('name');?></div></th>
                			<th><div><?php echo get_phrase('email');?></div></th>
                			<th><div><?php echo get_phrase('option');?></div></th>
                		</tr>
                	</thead>
                	<tbody>
                        <?php
                         $counter = 0;
                         foreach ($users->result_array() as $user): ?>
                            <tr>
                                <td><?php echo ++$counter; ?></td>

                                <td><?php echo $user['name']; ?></td>
                                <td><?php echo $user['email']; ?></td>
                                <td>
                                    <div class="bs-example">
                                      <div class="btn-group">
                                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                                          <?php echo get_phrase('action'); ?> <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-blue" role="menu">
                                            <li>
                                                <a href="<?php echo site_url('admin/user_form/edit/'.$user['id']); ?>" class="">
                                                    <i class="entypo-pencil"></i>
                                                    <?php echo get_phrase('edit'); ?>
                                                </a>
                                            </li>
                                          <li class="divider"></li>
                                          <li>
                                            <a href="#" class="" onclick="confirm_modal('<?php echo site_url('admin/users/delete/'.$user['id']); ?>');">
                                                <i class="entypo-trash"></i>
                                                <?php echo get_phrase('delete'); ?>
                                            </a>
                                          </li>
                                        </ul>
                                      </div>
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
        $('#user_table').DataTable({
            "scrollY": $(document).height() * 0.5,
            "scrollX": true,
            "ordering": false,
            "paging": false,
            "info": false
        });
    });
</script>