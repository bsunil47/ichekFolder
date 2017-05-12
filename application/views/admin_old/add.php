<div class="content">
    <div class="module">
        <div class="module-head">
            <h3>Add User</h3></div>
        <div class="module-body">
            <form class="form-horizontal row-fluid" action="<?php echo base_url() . 'Admin/users/add'; ?>" method="post">

                <div class="control-group">
                    <label class="control-label" for="basicinput">First Name:</label>
                    <div class="controls">
                        <?php echo form_input('firstname', $this->input->post('firstname'), 'id="firstname", class="span8" placeholder="Enter First Name" autocomplete="off"'); ?>
                        <?php echo form_error('firstname'); ?>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="basicinput">Last Name:</label>
                    <div class="controls">
                        <?php echo form_input('lastname', $this->input->post('lastname'), 'id="lastname", class="span8" placeholder="Enter Last Name" autocomplete="off"'); ?>
                        <?php echo form_error('lastname'); ?>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="basicinput">Email:</label>
                    <div class="controls">
                        <?php echo form_input('email', $this->input->post('email'), 'id="email", class="span8" placeholder="Enter Email" autocomplete="off"'); ?>
                        <?php echo form_error('email'); ?>
                    </div>
                </div>


                <div class="control-group">
                    <label class="control-label" for="basicinput">Phone:</label>
                    <div class="controls">
                        <?php echo form_input('phone', $this->input->post('phone'), 'id="phone", class="span8" placeholder="Enter Phone" autocomplete="off"'); ?>
                        <?php echo form_error('phone'); ?>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="basicinput">User Type:</label>
                    <div class="controls">
                        <select tabindex="1" data-placeholder="Select here.." class="span8" name="user_status" id="user_status">
                            <option name="">-Select-</option>
                            <option value="2">Finance Admin</option>
                            <option value="3">Account Admin</option>
                        </select>
                        <?php echo form_error('user_status'); ?>
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="basicinput">Address</label>
                    <div class="controls">
                        <?php echo form_textarea('address', $this->input->post('address'), 'id="address", class="span8" placeholder="Enter Address" autocomplete="off"'); ?>
                        <?php echo form_error('address'); ?>
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
                        <?php echo form_submit('submit', 'Add', 'id="submit"', 'name="submit"', 'class="btn-primary"'); ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>