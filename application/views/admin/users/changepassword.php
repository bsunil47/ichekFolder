<div class="content">
    <div class="module">
        <div class="module-head"><h3>Change Admin Password</h3></div>
        <div class="module-body">
            <form name="changepassword" method="post" action="">
                <div class="control-group">
                    <label class="control-label" for="basicinput">Old Password:</label>
                    <div class="controls">
                        <?php echo form_password('opassword', $this->input->post('opassword'), 'id="opassword", class="span8" placeholder="Enter Old Password" autocomplete="off"'); ?>
                        <?php echo form_error('opassword'); ?>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="basicinput">New Password:</label>
                    <div class="controls">
                        <?php echo form_password('npassword', $this->input->post('npassword'), 'id="npassword", class="span8" placeholder="Enter New Password" autocomplete="off"'); ?>
                        <?php echo form_error('npassword'); ?>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="basicinput">Confirm New Password:</label>
                    <div class="controls">
                        <?php echo form_password('cpassword', $this->input->post('cpassword'), 'id="cpassword", class="span8" placeholder="Enter Confirm Password" autocomplete="off"'); ?>
                        <?php echo form_error('cpassword'); ?>
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
                        <?php echo form_submit('submit', 'Send', 'id="submit"', 'class="btn"'); ?>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>