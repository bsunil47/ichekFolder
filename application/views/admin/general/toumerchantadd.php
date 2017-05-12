<div class="content">
    <div class="module">
        <div class="module-head">
            <h3>Add Terms of use for Business</h3></div>
        <div class="module-body">
            <form id="addfaq" name="addtoumerchant" class="form-horizontal row-fluid" action="<?php echo base_url() . 'Admin/general/toumerchantadd'; ?>" method="post">

                <div class="control-group">
                    <label class="control-label" for="heading">Heading:</label>
                    <div class="controls">
                        <?php echo form_input('heading', $this->input->post('heading'), 'id="heading", class="span8" placeholder="Enter heading" autocomplete="off"'); ?>
                        <?php echo form_error('heading'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="terms">Terms</label>
                    <div class="controls">
                        <?php echo form_textarea('terms', $this->input->post('terms'), 'id="terms", class="span8" placeholder="Enter Terms" autocomplete="off"'); ?>
                        <?php echo form_error('terms'); ?>
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