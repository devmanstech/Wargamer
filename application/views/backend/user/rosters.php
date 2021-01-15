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
                <table class="table table-bordered datatable">
                	<thead>
                		<tr>
                			<th width="80"><div>#</div></th>

                			<th width="60%"><div><?php echo get_phrase('name');?></div></th>
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

                                <td>
                                    <div class="bs-example">
                                      <div class="btn-group">
                                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                                          <?php echo get_phrase('action'); ?> <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-blue" role="menu">
                                            <li>
                                                <a href="<?php echo site_url('user/roster_form/view/'.$roster['id']); ?>" class="">
                                                    <i class="entypo-pencil"></i>
                                                    <?php echo get_phrase('view'); ?>
                                                </a>
                                            </li>
                                          <li class="divider"></li>
                                          <li>
                                            <a href="#" class="" onclick="confirm_modal('<?php echo site_url('user/rosters/delete/'.$roster['id']); ?>');">
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
