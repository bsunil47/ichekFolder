<div class="login_box">
    <?php echo form_open(base_url() . 'Admin'); ?>
    <div class="top_b">Sign in to iCheck Admin</div>    
    <div class="cnt_b">
        <div>
            <?php echo form_input('email', $this->input->post('email'), 'id="email", class="right_fields1" placeholder="Enter Email Address" autocomplete="off"'); ?>
            <?php echo form_error('email'); ?>
        </div>
        <div>
            <?php echo form_password('password', '', 'id="password", class="right_fields1" placeholder="Please Enter password" autocomplete="off"'); ?>
            <?php echo form_error('password'); ?>
        </div>

    </div>
    <div class="<?php echo $this->session->flashdata('type'); ?>" style="margin:0 auto; text-align: center"><?php echo $this->session->flashdata('msg'); ?></div>
    <div class="btm_b clearfix" align="center">
        <div align="left" style="float:left;"><a href="<?php echo base_url(); ?>Admin/users/forgotpassword" class="forgot">Forgot Password?</a></div>
        <div align="right" style="float:right;"><?php echo form_submit('submit', 'Login', 'id="submit"'); ?></div>
        <div style="clear:both;"></div>
    </div>
</div>  
<?php echo form_close(); ?>

</div>
