<nav id="menu" class="main-menu">
    <ul>
        <li><span><a href="<?php echo base_url();?>"><?php echo get_phrase('home'); ?></a></span></li>
        <li><span><a href="<?php echo base_url();?>home/blog"><?php echo get_phrase('blog'); ?></a></span></li>
        <?php if ($this->session->userdata('is_logged_in') == 1): ?>
            <li><span><a href="javascript::"><?php echo get_phrase('account'); ?></a></span>
                    <ul class="manage_account_navbar">
                        <?php 
                        if(strtolower($this->session->userdata('role'))=='user'){
                            ?>
<li><a href="<?php echo base_url(strtolower($this->session->userdata('role')).'/dashboard');?>"><?php echo get_phrase('manage_account'); ?></a></li>
                            <?php
                        }else{
                            ?>
<li><a href="<?php echo base_url(strtolower($this->session->userdata('role')).'/blogs');?>"><?php echo get_phrase('manage_account'); ?></a></li>
                            <?php
                        }
                        ?>
                        
                        <li><a href="<?php echo site_url('login/logout') ?>"><?php echo get_phrase('logout'); ?></a></li>
                    </ul>
                </li>
        <?php endif; ?>
    </ul>
</nav>

