<div class="sidebar-menu">
    <header class="logo-env" >

        <!-- logo collapse icon -->
        <div class="sidebar-collapse" style="margin-top: 0px;">
            <a href="#" class="sidebar-collapse-icon" onclick="hide_brand()">
                <i class="entypo-menu"></i>
            </a>
        </div>
        <script type="text/javascript">
        function hide_brand() {
            $('#branding_element').toggle();
        }
        </script>

        <!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
        <div class="sidebar-mobile-menu visible-xs">
            <a href="#" class="with-animation">
                <i class="entypo-menu"></i>
            </a>
        </div>
    </header>

    <div style=""></div>
    <ul id="main-menu" class="">
        <div style="text-align: -webkit-center;" id="branding_element">
            <img src="<?php echo base_url('assets/global/light_logo.png'); ?>"  style="max-height:30px;"/>
        </div>
        <br>
        
    
        <!-- Blogs -->
        <li class="<?php if ($page_name == 'blogs' || $page_name == 'add_blog_form' || $page_name == 'edit_blog_form') echo 'opened has-sub'; ?>">
            <a href="#">
                <i class="fa fa-align-left"></i>
                <span><?php echo get_phrase('blog'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'blogs') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/blogs'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('posts'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'add_blog_form') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/blog_form/add'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('add_new_post'); ?></span>
                    </a>
                </li>
            </ul>
        </li>


        <!-- Users -->
        <li class="<?php if ($page_name == 'agents' || $page_name == 'users' || $page_name == 'user_add' || $page_name == 'user_edit') echo 'opened active has-sub'; ?>">
            <a href="#">
                <i class="fa fa-users"></i>
                <span><?php echo get_phrase('users'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'users') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/users'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('users'); ?></span>
                    </a>
                </li>

                <li class="<?php if ($page_name == 'user_add') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/user_form/add'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('add_new_user'); ?></span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- SETTINGS -->
        <li class="<?php
        if ($page_name == 'system_settings' || $page_name == 'frontend_settings' || $page_name == 'payment_settings' || $page_name == 'manage_language' || $page_name == 'smtp_settings' || $page_name == 'about' ) echo 'opened active'; ?> ">
        <a href="#">
            <i class="fa fa-cogs"></i>
            <span><?php echo get_phrase('settings'); ?></span>
        </a>
        <ul>
            <li class="<?php if ($page_name == 'system_settings') echo 'active'; ?> ">
                <a href="<?php echo site_url('admin/system_settings'); ?>">
                    <span><i class="entypo-dot"></i> <?php echo get_phrase('system_settings'); ?></span>
                </a>
            </li>
            <li class="<?php if ($page_name == 'frontend_settings') echo 'active'; ?> ">
                <a href="<?php echo site_url('admin/frontend_settings'); ?>">
                    <span><i class="entypo-dot"></i> <?php echo get_phrase('frontend_settings'); ?></span>
                </a>
            </li>

            <li class="<?php if ($page_name == 'smtp_settings') echo 'active'; ?> ">
                <a href="<?php echo site_url('admin/smtp_settings'); ?>">
                    <span><i class="entypo-dot"></i> <?php echo get_phrase('smtp_settings'); ?></span>
                </a>
            </li>

        </ul>
    </li>
</ul>
</div>
