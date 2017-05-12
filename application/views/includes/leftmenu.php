<style>
    .collapse.in{
        border-color: #d5d5d5;
        border-width: 1px;
        border-style: solid;
    }
</style>
<div class="sidebar">
<!--    <ul class="widget widget-menu unstyled <?php if ($this->router->fetch_class() == 'users') { ?>active<?php } ?>">
        <li class= "<?php if ($this->router->fetch_method() == 'dashboard') { ?>active<?php } ?>" ><a href="<?php echo base_url(); ?>Admin/users/dashboard"><i class="menu-icon icon-dashboard"></i>Dashboard</a></li>

    </ul>-->
<!--    <ul class="widget widget-menu unstyled <?php if ($this->router->fetch_class() == 'users') { ?>active<?php } ?>">
        <li class="active"><i class="menu-icon icon-dashboard"></i><b>Account Management</b></li>
        <li class= "<?php if ($this->router->fetch_method() == 'userlist' || $this->router->fetch_method() == 'update') { ?>active<?php } ?>"><a href="<?php echo base_url(); ?>Admin/users/userlist"><i class="menu-icon icon-user"></i>Admin Users </a></li>
        <li class= "<?php if ($this->router->fetch_method() == 'merchants') { ?>active<?php } ?>"><a href='<?php echo base_url(); ?>Admin/users/merchants'><i class="menu-icon icon-user"></i>Merchants </a></li>
        <li class= "<?php if ($this->router->fetch_method() == 'customers') { ?>active<?php } ?>"><a href='<?php echo base_url(); ?>Admin/users/customers'><i class="menu-icon icon-user"></i>Customers </a></li>
    </ul>-->
    <!--    <ul class="widget widget-menu unstyled">
            <li class="active"><i class="menu-icon icon-dashboard <?php if ($this->router->fetch_class() == 'settings' || $this->router->fetch_class() == 'finance') { ?>active<?php } ?>"></i><b>Financial Administration</b></li>
    <?php //if($this->router->fetch_class().'/'.$this->router->fetch_method() == 'settings/index'){                                                                                                  ?>active<?php //}                                                                                                  ?>
            <li class= "<?php if ($this->router->fetch_method() == 'index' || $this->router->fetch_method() == 'edit') { ?>active<?php } ?>"><a  href="<?php echo base_url(); ?>Admin/settings"><i class="menu-icon icon-cog"></i>Ichek Admin/ Finance Settings</a></li>
            <li class= "<?php if ($this->router->fetch_method() == 'index') { ?>active<?php } ?>"><a  href="<?php echo base_url(); ?>Admin/finance"><i class="menu-icon icon-cog"></i>Cash Out List</a></li>
            <li class= "<?php if ($this->router->fetch_method() == 'topuplist') { ?>active<?php } ?>"><a href="<?php echo base_url(); ?>Admin/finance/topuplist"><i class="menu-icon icon-cog"></i>Top Up List</a></li>

        </ul>-->
    <!--    <ul class="widget widget-menu unstyled <?php if ($this->router->fetch_class() == 'settings' || $this->router->fetch_class() == 'points') { ?>active<?php } ?>">
            <li class="active"><i class="menu-icon icon-dashboard"></i><b>Status and Points Management</b></li>
            <li class= "<?php if ($this->router->fetch_method() == 'index' || $this->router->fetch_method() == 'update') { ?>active<?php } ?>"><a href="<?php echo base_url(); ?>Admin/points"><i class="menu-icon icon-cog"></i>Points Management</a></li>
            <li class= "<?php if ($this->router->fetch_method() == 'categories' || $this->router->fetch_method() == 'catedit' || $this->router->fetch_method() == 'addcat') { ?>active<?php } ?>"><a href="<?php echo base_url(); ?>Admin/settings/categories"><i class="menu-icon icon-cog"></i>Categories Management</a></li>

        </ul>-->
    <!--    <ul class="widget widget-menu unstyled <?php if ($this->router->fetch_class() == 'review') { ?>active<?php } ?>" >
        </ul>-->
    <!--    <ul class="widget widget-menu unstyled ">
            <li><i class="menu-icon icon-dashboard"></i><b>Merchant Invite Management</b></li>

        </ul>-->
    <!--    <ul class="widget widget-menu unstyled <?php if ($this->router->fetch_class() == 'merchants') { ?>active<?php } ?>" >

        </ul>
        <ul class="widget widget-menu unstyled <?php if ($this->router->fetch_class() == 'general') { ?>active<?php } ?>">

        </ul>-->
    <!--    <ul class="widget widget-menu unstyled <?php if ($this->router->fetch_class() == 'general') { ?>active<?php } ?>">
            <li><i class="menu-icon icon-dashboard"></i><b>General Management</b></li>
            <li class= "<?php if ($this->router->fetch_method() == 'faq' || $this->router->fetch_method() == 'faqadd' || $this->router->fetch_method() == 'faqedit') { ?>active<?php } ?>"><a href="<?php echo base_url(); ?>Admin/general/faq"><i class="menu-icon icon-dashboard"></i>FAQ's</a></li>
            <li class= "<?php if ($this->router->fetch_method() == 'feedback') { ?>active<?php } ?>"><a href="<?php echo base_url(); ?>Admin/general/feedback"><i class="menu-icon icon-user"></i>Feedback </a></li>
            <li class= "<?php if ($this->router->fetch_method() == 'contact') { ?>active<?php } ?>"><a href="<?php echo base_url(); ?>Admin/general/contact"><i class="menu-icon icon-user"></i>ContactUs </a></li>
            <li class= "<?php if ($this->router->fetch_method() == 'toucust' || $this->router->fetch_method() == 'toucustadd' || $this->router->fetch_method() == 'toucustedit') { ?>active<?php } ?>"><a href='<?php echo base_url(); ?>Admin/general/toucust'><i class="menu-icon icon-user"></i>Terms of use for Customers </a></li>
            <li class= "<?php if ($this->router->fetch_method() == 'toumerchant' || $this->router->fetch_method() == 'toumerchantadd' || $this->router->fetch_method() == 'toumerchantedit') { ?>active<?php } ?>"><a href='<?php echo base_url(); ?>Admin/general/toumerchant'><i class="menu-icon icon-user"></i>Terms of use for Merchant </a></li>
        </ul>-->
    <!--</ul>-->
    <ul class="widget widget-menu unstyled ">
        <li class= "<?php if ($this->router->fetch_method() == 'dashboard') { ?>active<?php } ?>" ><a href="<?php echo base_url(); ?>Admin/users/dashboard"><i class="menu-icon icon-dashboard"></i>Dashboard</a></li>
        <li><a class="<?php if ($this->router->fetch_class() != 'users' && !($this->router->fetch_method() == 'userlist' || $this->router->fetch_method() == 'update' || $this->router->fetch_method() == 'merchants' || $this->router->fetch_method() == 'customers')) { ?>collapsed<?php } ?>" data-toggle="collapse" href="#togglePages6"><i class="menu-icon icon-group">
                </i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right">
                </i>Account Management</a>
            <ul id="togglePages6" class="unstyled <?php if ($this->router->fetch_class() == 'users' && ($this->router->fetch_method() == 'userlist' || $this->router->fetch_method() == 'update' || $this->router->fetch_method() == 'merchants' || $this->router->fetch_method() == 'customers' || $this->router->fetch_method() == 'add')) { ?>in<?php } ?> collapse" >
                <li class= "<?php if ($this->router->fetch_method() == 'userlist' || $this->router->fetch_method() == 'update' || $this->router->fetch_method() == 'add') { ?>active<?php } ?>"><a href="<?php echo base_url(); ?>Admin/users/userlist"><i class="menu-icon icon-user"></i>Admin Users </a></li>
                <li class= "<?php if ($this->router->fetch_method() == 'merchants') { ?>active<?php } ?>"><a href='<?php echo base_url(); ?>Admin/users/merchants'><i class="menu-icon icon-user"></i>Merchants </a></li>
                <li class= "<?php if ($this->router->fetch_method() == 'customers') { ?>active<?php } ?>"><a href='<?php echo base_url(); ?>Admin/users/customers'><i class="menu-icon icon-user"></i>Customers </a></li>
            </ul>
        </li>
        <li><a class="<?php if (!(($this->router->fetch_class() == 'settings' || $this->router->fetch_class() == 'finance') && ($this->router->fetch_method() == 'index' || $this->router->fetch_method() == 'topuplist' || $this->router->fetch_method() == 'add'))) { ?>collapsed<?php } ?>" data-toggle="collapse" href="#togglePages5"><i class="menu-icon icon-exchange">
                </i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right">
                </i>Financial Administration</a>
            <ul id="togglePages5" class="unstyled <?php if (($this->router->fetch_class() == 'settings' || $this->router->fetch_class() == 'finance') && ((($this->router->fetch_class() == 'settings' || $this->router->fetch_class() == 'finance') && $this->router->fetch_method() == 'index') || $this->router->fetch_method() == 'topuplist' || $this->router->fetch_method() == 'add')) { ?>in<?php } ?> collapse">
                <li class= "<?php if ($this->router->fetch_class() == 'settings' && ($this->router->fetch_method() == 'index' || $this->router->fetch_method() == 'edit' || $this->router->fetch_method() == 'add')) { ?>active<?php } ?>"><a  href="<?php echo base_url(); ?>Admin/settings"><i class="menu-icon icon-cog"></i>Ichek Admin/ Finance Settings</a></li>
                <li class= "<?php if ($this->router->fetch_class() == 'finance' && $this->router->fetch_method() == 'index') { ?>active<?php } ?>"><a  href="<?php echo base_url(); ?>Admin/finance"><i class="menu-icon icon-arrow-down"></i>Cash Out List</a></li>
                <li class= "<?php if ($this->router->fetch_method() == 'topuplist') { ?>active<?php } ?>"><a href="<?php echo base_url(); ?>Admin/finance/topuplist"><i class="menu-icon icon-arrow-up"></i>Top Up List</a></li>
            </ul>
        </li>
        <li><a class="<?php if (!(($this->router->fetch_class() == 'settings' || $this->router->fetch_class() == 'points') && (($this->router->fetch_method() == 'index' && $this->router->fetch_class() == 'points') || $this->router->fetch_method() == 'update' || $this->router->fetch_method() == 'categories' || $this->router->fetch_method() == 'catedit' || $this->router->fetch_method() == 'addcat' || $this->router->fetch_method() == 'status' || $this->router->fetch_method() == 'addstatus' || $this->router->fetch_method() == 'statusedit'))) { ?>collapsed<?php } ?>" data-toggle="collapse" href="#togglePages4"><i class="menu-icon icon-cogs">
                </i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right">
                </i>Status and Points Management</a>
            <ul id="togglePages4" class="unstyled <?php if (($this->router->fetch_class() == 'settings' || $this->router->fetch_class() == 'points') && (($this->router->fetch_method() == 'index' && $this->router->fetch_class() == 'points') || $this->router->fetch_method() == 'update' || $this->router->fetch_method() == 'categories' || $this->router->fetch_method() == 'catedit' || $this->router->fetch_method() == 'addcat' || $this->router->fetch_method() == 'status' || $this->router->fetch_method() == 'addstatus' || $this->router->fetch_method() == 'statusedit')) { ?>in <?php } ?>collapse">
                <li class= "<?php if ($this->router->fetch_method() == 'index' || $this->router->fetch_method() == 'update') { ?>active<?php } ?>"><a href="<?php echo base_url(); ?>Admin/points"><i class="menu-icon icon-cog"></i>Points Management</a></li>
                <li class= "<?php if ($this->router->fetch_method() == 'categories' || $this->router->fetch_method() == 'catedit' || $this->router->fetch_method() == 'addcat') { ?>active<?php } ?>"><a href="<?php echo base_url(); ?>Admin/settings/categories"><i class="menu-icon icon-cog"></i>Categories Management</a></li>
                <li class= "<?php if ($this->router->fetch_method() == 'status' || $this->router->fetch_method() == 'statusedit' || $this->router->fetch_method() == 'addstatus') { ?>active<?php } ?>"><a href="<?php echo base_url(); ?>Admin/settings/status"><i class="menu-icon icon-cog"></i>Status Management</a></li>
            </ul>
        </li>
        <li><a class="<?php if (!($this->router->fetch_class() == 'review' && ($this->router->fetch_method() == 'index' || $this->router->fetch_method() == 'edit' || $this->router->fetch_method() == 'reports' || $this->router->fetch_method() == 'reportsedit'))) { ?>collapsed<?php } ?>" data-toggle="collapse" href="#togglePages3"><i class="menu-icon icon-pencil">
                </i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right">
                </i>Review Management <?php
                $un = $this->common_model->pureQuery("select count(*) as num from tbl_offerreviews where status=2 and viewstatus=0");
                if ($un[0]->num != 0) {
                    ?><b class="label orange pull-right">
                        <?php echo $un[0]->num; ?></b><?php } ?></a>
            <ul id="togglePages3" class="unstyled <?php if ($this->router->fetch_class() == 'review' && ($this->router->fetch_method() == 'index' || $this->router->fetch_method() == 'edit' || $this->router->fetch_method() == 'reports' || $this->router->fetch_method() == 'reportsedit')) { ?>in <?php } ?>collapse">
                <li class= "<?php if ($this->router->fetch_method() == 'index' || $this->router->fetch_method() == 'edit') { ?>active<?php } ?>"><a href="<?php echo base_url(); ?>Admin/review"><i class="menu-icon icon-bullhorn"></i>Reviews</a></li>
                <li class= "<?php if ($this->router->fetch_method() == 'reports' || $this->router->fetch_method() == 'reportsedit') { ?>active<?php } ?>"><a href="<?php echo base_url(); ?>Admin/review/reports"><i class="menu-icon icon-bullhorn"></i>Reported Reviews <?php if ($un[0]->num != 0) { ?><b class="label orange pull-right">
                                <?php echo $un[0]->num; ?></b><?php } ?></a></li>
            </ul>
        </li>
        <li><a class="<?php if (!(($this->router->fetch_class() == 'merchants' || $this->router->fetch_class() == 'merchants_1') && ($this->router->fetch_method() == 'upload_excel' || $this->router->fetch_method() == 'index' || $this->router->fetch_method() == 'view' || $this->router->fetch_method() == 'invitebusiness'))) { ?>collapsed<?php } ?>" data-toggle="collapse" href="#togglePages2"><i class="menu-icon icon-money">
                </i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right">
                </i>Merchant Invite Management</a>
            <ul id="togglePages2" class="unstyled <?php if (($this->router->fetch_class() == 'merchants' || $this->router->fetch_class() == 'merchants_1') && ($this->router->fetch_method() == 'upload_excel' || $this->router->fetch_method() == 'index' || $this->router->fetch_method() == 'view' || $this->router->fetch_method() == 'invitebusiness')) { ?>in <?php } ?>collapse">

                <li class= "<?php if ($this->router->fetch_class() == 'merchants' && $this->router->fetch_method() == 'upload_excel') { ?>active<?php } ?>"><a  href="<?php echo base_url(); ?>Admin/merchants/upload_excel"><i class="menu-icon icon-user"></i>Add Business</a></li>
                <li class= "<?php if ($this->router->fetch_class() == 'merchants' && $this->router->fetch_method() == 'index' || $this->router->fetch_method() == 'view') { ?>active<?php } ?>"><a href="<?php echo base_url(); ?>Admin/merchants"><i class="menu-icon icon-user"></i>Businesses</a></li>
                <!--<li class= "<?php //if ($this->router->fetch_class() == 'merchants_1' && $this->router->fetch_method() == 'index' || $this->router->fetch_method() == 'view') {   ?>active<?php // }   ?>"><a href="<?php //echo base_url();   ?>Admin/merchants_1"><i class="menu-icon icon-user"></i>Businesses from CoreList</a></li>-->
                <li class= "<?php if ($this->router->fetch_class() == 'merchants' && $this->router->fetch_method() == 'invitebusiness') { ?>active<?php } ?>"><a href="<?php echo base_url(); ?>Admin/merchants/invitebusiness"><i class="menu-icon icon-user"></i>Invited Business</a></li>
               <!-- <li class= "<?php if ($this->router->fetch_class() == 'merchants_1' && ($this->router->fetch_method() == 'index' || $this->router->fetch_method() == 'view')) { ?>active<?php } ?>"><a href="<?php echo base_url(); ?>Admin/merchants_1"><i class="menu-icon icon-user"></i>newly added Businesses </a></li>
                <li class= "<?php if ($this->router->fetch_class() == 'merchants_1' && $this->router->fetch_method() == 'upload_excel') { ?>active<?php } ?>"><a  href="<?php echo base_url(); ?>Admin/merchants_1/upload_excel"><i class="menu-icon icon-user"></i>Add Business New</a></li>-->

            </ul>
        </li>
        <li class= "<?php if ($this->router->fetch_method() == 'followers_management') { ?>active<?php } ?>"><a href="<?php echo base_url(); ?>Admin/merchants/followers_management"><i class="menu-icon icon-group"></i>Followers Management</a></li>
        <li class= "<?php if ($this->router->fetch_method() == 'emailblast') { ?>active<?php } ?>"><a href="<?php echo base_url(); ?>Admin/merchants/emailblast"><i class="menu-icon icon-envelope"></i>Email Blast Management</a></li>
        <!--<li class="<?php if ($this->router->fetch_method() == 'proximal') { ?>active<?php } ?>"><a href="<?php echo base_url(); ?>Admin/general/proximal"><i class="menu-icon icon-search"></i>Search Managment Proximality </a></li>-->
        <li><a class="<?php if (!($this->router->fetch_class() == 'general' && ($this->router->fetch_method() == 'faq' || $this->router->fetch_method() == 'faqadd' || $this->router->fetch_method() == 'faqedit' || $this->router->fetch_method() == 'feedback' || $this->router->fetch_method() == 'contact' || $this->router->fetch_method() == 'toucust' || $this->router->fetch_method() == 'toucustadd' || $this->router->fetch_method() == 'toucustedit' || $this->router->fetch_method() == 'toumerchant' || $this->router->fetch_method() == 'toumerchantadd' || $this->router->fetch_method() == 'toumerchantedit'))) { ?>collapsed<?php } ?>" data-toggle="collapse" href="#togglePages"><i class="menu-icon icon-globe">
                </i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right">
                </i>General Management </a>
            <ul id="togglePages" class="unstyled <?php if ($this->router->fetch_class() == 'general' && ($this->router->fetch_method() == 'faq' || $this->router->fetch_method() == 'faqadd' || $this->router->fetch_method() == 'faqedit' || $this->router->fetch_method() == 'feedback' || $this->router->fetch_method() == 'contact' || $this->router->fetch_method() == 'toucust' || $this->router->fetch_method() == 'toucustadd' || $this->router->fetch_method() == 'toucustedit' || $this->router->fetch_method() == 'toumerchant' || $this->router->fetch_method() == 'toumerchantadd' || $this->router->fetch_method() == 'toumerchantedit')) { ?>in <?php } ?>collapse" >
                <li class= "<?php if ($this->router->fetch_method() == 'faq' || $this->router->fetch_method() == 'faqadd' || $this->router->fetch_method() == 'faqedit') { ?>active<?php } ?>"><a href="<?php echo base_url(); ?>Admin/general/faq"><i class="menu-icon icon-question-sign"></i>FAQ's</a></li>
                <li class= "<?php if ($this->router->fetch_method() == 'feedback') { ?>active<?php } ?>"><a href="<?php echo base_url(); ?>Admin/general/feedback"><i class="menu-icon icon-comment"></i>Feedback </a></li>
                <li class= "<?php if ($this->router->fetch_method() == 'contact') { ?>active<?php } ?>"><a href="<?php echo base_url(); ?>Admin/general/contact"><i class="menu-icon icon-envelope"></i>ContactUs </a></li>
                <li class= "<?php if ($this->router->fetch_method() == 'toucust' || $this->router->fetch_method() == 'toucustadd' || $this->router->fetch_method() == 'toucustedit') { ?>active<?php } ?>"><a href='<?php echo base_url(); ?>Admin/general/toucust'><i class="menu-icon icon-info-sign"></i>Terms of use for Customers </a></li>
                <li class= "<?php if ($this->router->fetch_method() == 'toumerchant' || $this->router->fetch_method() == 'toumerchantadd' || $this->router->fetch_method() == 'toumerchantedit') { ?>active<?php } ?>"><a href='<?php echo base_url(); ?>Admin/general/toumerchant'><i class="menu-icon icon-info-sign"></i>Terms of use for Merchant </a></li>
            </ul>
        </li>
        <li><a class="<?php if (!($this->router->fetch_class() == 'statistics' && ($this->router->fetch_method() == 'index' || $this->router->fetch_method() == 'activeusers' || $this->router->fetch_method() == 'activeoffers' || $this->router->fetch_method() == 'sorting' || $this->router->fetch_method() == 'sortingdata'))) { ?>collapsed<?php } ?>" data-toggle="collapse" href="#togglePages1"><i class="menu-icon icon-bar-chart">
                </i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right">
                </i>Statistics </a>
            <ul id="togglePages1" class="unstyled <?php if ($this->router->fetch_class() == 'statistics' && ($this->router->fetch_method() == 'index' || $this->router->fetch_method() == 'activeusers' || $this->router->fetch_method() == 'activeoffers' || $this->router->fetch_method() == 'sorting' || $this->router->fetch_method() == 'sortingdata')) { ?>in <?php } ?> collapse" >
                <li class="<?php if ($this->router->fetch_method() == 'index') { ?>active<?php } ?>"><a  href="<?php echo base_url(); ?>Admin/statistics"><i class="menu-icon icon-cog"></i>Most Redeemed Offer</a></li>
                <li class="<?php if ($this->router->fetch_method() == 'activeusers') { ?>active<?php } ?>"><a href="<?php echo base_url(); ?>Admin/statistics/activeusers"><i class="menu-icon icon-user"></i>Most Active Users</a></li>
                <li class="<?php if ($this->router->fetch_method() == 'activeoffers') { ?>active<?php } ?>"><a href="<?php echo base_url(); ?>Admin/statistics/activeoffers"><i class="menu-icon icon-user"></i>Most Active Merchants</a></li>
                <li class="<?php if ($this->router->fetch_method() == 'sorting') { ?>active<?php } ?>"><a  href="<?php echo base_url(); ?>Admin/statistics/sorting"><i class="menu-icon icon-search"></i>Advance Redeem Filter</a></li>
            </ul>
        </li>
    <!--    <li class="active"><i class="menu-icon icon-dashboard"></i><b>Statistics</b></li></li>-->

    </ul>

</div>
