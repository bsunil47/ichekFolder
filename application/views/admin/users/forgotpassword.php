<div class="module module-login span4 offset4">
    <?php echo form_open(base_url() . 'Admin'); ?>
    <div class="module-head"><h3>Forgot password</h3></div>
    <div class="module-body">
        <div class="control-group">
            <div class="controls row-fluid">
                <?php echo form_input('email', $this->input->post('email'), 'id="email", class="span12" placeholder="Enter Email Address" autocomplete="off"'); ?>
                <?php echo form_error('email'); ?>
            </div>
        </div>
    </div>

    <div class="<?php echo $this->session->flashdata('type'); ?>" style="margin:0 auto; text-align: center"><?php echo $this->session->flashdata('msg'); ?></div>

    <div class="module-foot">
        <div class="control-group">
            <div class="controls clearfix">
                <input type="submit" name="submit" id="submit" value="Send" class="btn btn-primary pull-right" />
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
