<div class="row ">
  <div class="col-lg-8 col-md-10 col-sm-12">
    <a href="<?php echo site_url('admin/blog_form/add'); ?>" class="btn btn-primary alignToTitle"><i class="entypo-plus"></i><?php echo get_phrase('add_new_post'); ?></a>
  </div><!-- end col-->
</div>
<div class="row">
  <div class="col-lg-8 col-md-10 col-sm-12">
    <div class="panel panel-primary" data-collapsed="0">
      <div class="panel-heading">
        <div class="panel-title">
          <?php echo get_phrase('post_list'); ?>
        </div>
      </div>
      <div class="panel-body">
        <table id="blog_table" style="font-size:14px;">
          <thead>
            <tr>
              <th width="80">#</th>
              <th><?php echo get_phrase('title');?></th>
                          
              <th><?php echo get_phrase('status');?></th>
              <th><?php echo get_phrase('options');?></th>
            </tr>
          </thead>
          <tbody>
            <?php $count = 0; ?>
            <?php foreach($blogs as $blog): ?>
            <?php $count++; ?>
              <tr>
                <td><?php echo $count; ?></td>
                <td><a href="<?php echo site_url('home/post/'.$blog['id'].'/'.slugify($blog['title'])); ?>" target="_blank"><?php echo $blog['title']; ?></a></td>
                             
                <td>
                  <?php if($blog['status'] == 1): ?>
                    <span class="label label-success"><?php echo get_phrase('active'); ?></span>
                  <?php else: ?>
                    <span class="label label-default"><?php echo get_phrase('inactive'); ?></span>
                  <?php endif; ?>
                </td>
                <td>
                  <div class="bs-example">
                    <div class="btn-group">
                      <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                        <?php echo get_phrase('action'); ?> <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu dropdown-blue" role="menu">
                        <li>
                          <?php if($blog['status'] == 1): ?>
                            <a href="<?php echo site_url('admin/blog_status/inactive/'.$blog['id']); ?>" class="">
                              <i class="entypo-check"></i>
                              <span><?php echo get_phrase('mark_as_inactive'); ?></span>
                            </a>
                          <?php else: ?>
                            <a href="<?php echo site_url('admin/blog_status/active/'.$blog['id']); ?>" class="">
                              <i class="entypo-check"></i>
                              <span><?php echo get_phrase('mark_as_active'); ?></span>
                            </a>
                          <?php endif; ?>
                        </li>
                        <li>
                          <a href="<?php echo site_url('admin/blog_form/edit/'.$blog['id']); ?>">
                            <i class="entypo-pencil"></i>
                            <?php echo get_phrase('edit'); ?>
                          </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                          <a href="#" onclick="confirm_modal('<?php echo site_url('admin/delete_blog/'.$blog['id']); ?>');">
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
  </div>
</div>

<script>
    $(document).ready(function () {
        $('#blog_table').DataTable({            
            "scrollX": true,
            "ordering": false,
            "paging": false,
            "info": false
        });
    });
</script>