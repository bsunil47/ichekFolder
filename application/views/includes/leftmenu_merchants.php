<style>
    .collapse.in{
        border-color: #d5d5d5;
        border-width: 1px;
        border-style: solid;
    }
</style>
<div class="sidebar">
    <ul class="widget widget-menu unstyled ">
        <li class= "<?php if ($this->router->fetch_class() == 'merchants' && $this->router->fetch_method() == 'index') { ?>active<?php } ?>" ><a href="<?php echo base_url(); ?>merchants/index"><i class="menu-icon icon-dashboard"></i>Dashboard</a></li>
        <li><a class="<?php if ($this->router->fetch_class() != 'merchants' && !($this->router->fetch_method() == 'cashout' || $this->router->fetch_method() == 'topup')) { ?>collapsed<?php } ?>" data-toggle="collapse" href="#togglePages5"><i class="menu-icon icon-exchange">
                </i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right">
                </i>Financial Administration</a>
            <ul id="togglePages5" class="unstyled <?php if ($this->router->fetch_class() == 'merchants' && ($this->router->fetch_method() == 'cashout' || $this->router->fetch_method() == 'topup')) { ?>in<?php } ?> collapse">
                <!--<li class= "<?php //if ($this->router->fetch_method() == 'index' || $this->router->fetch_method() == 'edit') {     ?>active<?php //}     ?>"><a  href="javascript:void(0);"><i class="menu-icon icon-cog"></i>Finance Settings</a></li>-->
                <li class= "<?php if ($this->router->fetch_method() == 'cashout') { ?>active<?php } ?>"><a  href="<?php echo base_url(); ?>merchants/cashout"><i class="menu-icon icon-arrow-right"></i>Cash Out List</a></li>
                <li class= "<?php if ($this->router->fetch_method() == 'topup') { ?>active<?php } ?>"><a href="<?php echo base_url(); ?>merchants/topup"><i class="menu-icon icon-arrow-up"></i>Top Up List</a></li>
            </ul>
        </li>
        <li class= "<?php if ($this->router->fetch_method() == 'follower') { ?>active<?php } ?>"><a href="<?php echo base_url(); ?>merchants/follower"><i class="menu-icon icon-group"></i>Followers Management</a></li>
        <li class= "<?php if ($this->router->fetch_method() == 'emailblast') { ?>active<?php } ?>"><a href="<?php echo base_url(); ?>merchants/emailblast"><i class="menu-icon icon-envelope"></i>Email Blast List</a></li>

    </ul>
</div>