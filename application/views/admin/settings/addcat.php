<div class="content">
    <div class="module">
        <div class="module-head"><h3>Add Category</h3></div>
        <div class="module-body">
            <form id="addcat" class="form-horizontal row-fluid" action="<?php echo base_url() . 'Admin/settings/addcat'; ?>" method="post">
                <div class="control-group">
                    <label class="control-label" for="basicinput">Category:</label>
                    <div class="controls">
                        <?php echo form_input('catname', $this->input->post('catname'), 'id="catname", class="span8" placeholder="Enter Category" autocomplete="off"'); ?>
                        <?php echo form_error('catname'); ?>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="basicinput">Status:</label>
                    <div class="controls">

                        <select tabindex="1" data-placeholder="Select here.." class="span8" name="status" id="status">
                            <option value="">-Select-</option>
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
</div>			
