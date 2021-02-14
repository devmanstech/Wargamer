<div class="col-lg-12">
			<div class="row">
			
				<?php foreach($matches as $match):
					$player1 = $this->db->get_where('user', array('id'=>$match['player1_id']))->row();
					$player2 = $this->db->get_where('user', array('id'=>$match['player2_id']))->row();
					$winner = $this->db->get_where('user', array('id'=>$match['winner']))->row();
					
					?>
					<?php if($match['status'] != 0): ?>
						<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
							<article class="blog" style="margin-top:40px">
								
								<div class="post_info">
									
									<h2 class="text-align-last:center"><?php
									
									echo $player1->name ," vs " ,$player2->name ?></h2>
									<p>
									
										<?php 
					                    echo "<span style='font-weight:bolder'>".$player1->name."'s faction :</span>".$match['player1_faction']  ;
					                    ?>
									

									<br>
									
										<?php 
					                    echo "<span style='font-weight:bolder'>".$player2->name."'s faction :</span> ".$match['player2_faction']  ;
					                    ?>

									<br>

									<?php
									if($match['winner'] == '0'){
										echo "<span style='font-weight:bolder'>Winner :</span>  None";
									}else{
										echo "<span style='font-weight:bolder'>Winner :</span> ".$winner->name;
									}
									
									?>
									</p>

									<p style="float:right">
									<?php echo date('d M Y', strtotime($match['created_at'])); ?>
									</p>
									
										
								</div>
							</article>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
			<!-- /row -->

			<!-- /pagination -->
			<nav class="text-center">
				<?php echo $this->pagination->create_links(); ?>
			</nav>
			<!-- /pagination -->
			
		</div>