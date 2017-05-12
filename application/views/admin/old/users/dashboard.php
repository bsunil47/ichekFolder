<div class="content">
    <div class="btn-controls">
        <div class="btn-box-row row-fluid">
            <a href="<?php echo base_url(); ?>Admin/users/userlist"  class="btn-box big span4"><i class=" icon-user"></i><b><?php echo $users->count; ?></b>
                <p class="text-muted">
                    Users</p>
            </a><a href="<?php echo base_url(); ?>Admin/users/merchants" class="btn-box big span4"><i class="icon-user"></i><b><?php echo $merchant->count; ?></b>
                <p class="text-muted">
                    Merchants</p>
            </a><a href="<?php echo base_url(); ?>Admin/users/customers" class="btn-box big span4"><i class="icon-user"></i><b><?php echo $customers->count; ?></b>
                <p class="text-muted">
                    Customers</p>
            </a>
        </div>

    </div>
</div>