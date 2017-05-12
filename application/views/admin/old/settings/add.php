<div class="content">
    <div class="module">
        <div class="module-head">

            <h3>Add Settings</h3></div>
        <div class="module-body">

            <form class="form-horizontal row-fluid" action="<?php echo base_url() . 'Admin/settings/add'; ?>" method="post">

                <div class="control-group">
                    <label class="control-label" for="basicinput">Cpc:</label>
                    <div class="controls">

                        <?php echo form_input('cpc', $this->input->post('cpc'), 'id="cpc", class="span8" placeholder="Enter Cpc" autocomplete="off"'); ?>
                        <?php echo form_error('cpc'); ?>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="basicinput">Paypal Id:</label>
                    <div class="controls">
                        <?php echo form_input('paypal_id', $this->input->post('paypal_id'), 'id="paypal_id", class="span8" placeholder="Enter Paypal Id" autocomplete="off"'); ?>
                        <?php echo form_error('paypal_id'); ?>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="basicinput">Cashout Minimum Points:</label>
                    <div class="controls">
                        <?php echo form_input('cashout_min_points', $this->input->post('cashout_min_points'), 'id="cashout_min_points", class="span8" placeholder="Enter Cashout Min Points" autocomplete="off"'); ?>
                        <?php echo form_error('cashout_min_points'); ?>
                    </div>
                </div>


                <div class="control-group">
                    <label class="control-label" for="basicinput">Cashout Fee:</label>
                    <div class="controls">
                        <?php echo form_input('cash_out_fee', $this->input->post('cash_out_fee'), 'id="cash_out_fee", class="span8" placeholder="Enter Cashout Fee" autocomplete="off"'); ?>
                        <?php echo form_error('cash_out_fee'); ?>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="basicinput">Maximum Cashout:</label>
                    <div class="controls">
                        <?php echo form_input('max_cash_out', $this->input->post('max_cash_out'), 'id="max_cash_out", class="span8" placeholder="Enter Maximum Cashout" autocomplete="off"'); ?>
                        <?php echo form_error('max_cash_out'); ?>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="basicinput">Status:</label>
                    <div class="controls">

                        <select tabindex="1" data-placeholder="Select here.." class="span8" name="status" id="status">
                            <option name="">-Select-</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        <?php echo form_error('status'); ?>
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
                        <?php echo form_submit('submit', 'Add', 'id="submit"', 'name="submit"', 'class="btn"'); ?>

                    </div>
                </div>

            </form>
        </div>
    </div>
    <!--/.module-->
</div>