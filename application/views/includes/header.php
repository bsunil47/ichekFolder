<div class="navbar-inner">
    <div class="container">
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
            <i class="icon-reorder shaded"></i></a><a class="brand" href="<?php echo base_url(); ?>Admin/users/dashboard" style="padding: 0;"><img src="<?php echo base_url(); ?>images/logo.png" style="height:70px"/> </a>
        <div class="nav-collapse collapse navbar-inverse-collapse">
            <ul class="nav pull-right">
                <li class="nav-user dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?php echo base_url(); ?>images/default_user.png" class="nav-avatar" />
                        <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <!--<li><a href="#">Your Profile</a></li>-->
                        <li><a href="<?php echo base_url(); ?>Admin/users/profile" <?php
                            if ($menuid == 'profile') {
                                echo 'style="display:block; color:#ff6a00;"';
                            }
                            ?>>Edit Profile</a></li>
                        <li><a href="<?php echo base_url(); ?>Admin/users/changepassword" <?php
                            if ($menuid == 'changepassword') {
                                echo 'style="display:block; color:#ff6a00;"';
                            }
                            ?>>Change Password</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url(); ?>Admin/users/logout">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- /.nav-collapse -->
    </div>
</div>
<!-- /navbar-inner -->