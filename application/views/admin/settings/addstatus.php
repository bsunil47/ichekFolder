<div class="content">
    <div class="module">
        <div class="module-head"><h3>Add Status</h3></div>
        <div class="module-body">
            <form id="addcat" class="form-horizontal row-fluid" action="<?php echo base_url() . 'Admin/settings/addstatus'; ?>" method="post">
                <div class="control-group">
                    <label class="control-label" for="basicinput">Status Name:</label>
                    <div class="controls">
                        <?php echo form_input('name', $this->input->post('name'), 'id="name", class="span8" placeholder="Enter Status Name" autocomplete="off"'); ?>
                        <?php echo form_error('name'); ?>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="basicinput">Status Points:</label>
                    <div class="controls">
                        <?php echo form_input('points', $this->input->post('points'), 'id="points", class="span8" placeholder="Enter Status points" autocomplete="off"'); ?>
                        <?php echo form_error('points'); ?>
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
</div>			
