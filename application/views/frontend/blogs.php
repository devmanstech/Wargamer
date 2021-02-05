<div class="container margin_60_35">
	<div class="row">
		<?php if($blog_detail_page == 1):
			include 'blog_detail_page.php';
		else:
			include 'blog_main_page.php';
		endif; ?>

		<aside class="col-lg-3">
			<div class="widget search_blog">
				<label><?php echo get_phrase('title'); ?>, <?php echo get_phrase('description'); ?></label>
				<div class="form-group">
					<input type="text" name="search" value="<?php if($searching_value != ''){ echo $searching_value; } ?>" id="searching_key" class="form-control" placeholder="<?php echo get_phrase('search'); ?>..">
					<span><input type="submit" id="blog_searching_btn" onclick="blog_search()" value="<?php echo get_phrase('search'); ?>" style="cursor: pointer;"></span>
				</div>
			</div>
			<!-- /widget -->
			<div class="widget">
				<div class="widget-title">
					<h4><?php echo get_phrase('latest_post'); ?></h4>
				</div>
				<ul class="comments-list">
					<?php foreach($this->frontend_model->latest_blog_post() as $latest_post): ?>
						<li>
							<div class="alignleft">
								<a href="<?php echo site_url('home/post/'.$latest_post['id'].'/'.slugify($latest_post['title'])); ?>">
									<?php if(file_exists('uploads/blog_thumbnails/'.$latest_post['blog_thumbnail'])): ?>
										<img src="<?php echo base_url('uploads/blog_thumbnails/'.$latest_post['blog_thumbnail']); ?>" alt="...">
									<?php else: ?>
										<img src="<?php echo base_url('uploads/blog_thumbnails/thumbnail.png'); ?>" alt="...">
									<?php endif; ?>
								</a>
							</div>
							<?php echo date('d M Y', $latest_post['added_date']); ?></small>
							<h3>
								<a href="<?php echo site_url('home/post/'.$latest_post['id'].'/'.slugify($latest_post['title'])); ?>">
									<?php
				                      $string = strip_tags($latest_post['blog_text']);
				                      if (strlen($string) > 55) {

				                          // truncate string
				                          $stringCut = substr($string, 0, 55);
				                          $endPoint = strrpos($stringCut, ' ');

				                          //if the string doesn't contain any space then it will cut without word basis.
				                          $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
				                          $string .= '...';
				                      }
				                      echo $string;
				                    ?>
								</a>
							</h3>
							<!-- <small><i class="ti-comment pt-2"></i><span class="" style="">20</span></small> -->
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
			
		</aside>
		<!-- /aside -->
	</div>
	<!-- /row -->
</div>
<!-- /container -->

<script>
	function blog_search(){
		var searching_value = $('#searching_key').val();
		if(searching_value != ''){
			location.replace("<?php echo site_url('home/blog?search='); ?>"+searching_value);
		}else{
			location.replace("<?php echo site_url('home/blog'); ?>");
		}
	}


// Get the input field
var input = document.getElementById("searching_key");

// Execute a function when the user releases a key on the keyboard
input.addEventListener("keyup", function(event) {
  // Number 13 is the "Enter" key on the keyboard
  if (event.keyCode === 13) {
    // Cancel the default action, if needed
    event.preventDefault();
    // Trigger the button element with a click
    document.getElementById("blog_searching_btn").click();
  }
});
</script>
