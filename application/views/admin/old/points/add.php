<div class="content">
    <div class="module">
        <div class="module-head">

            <h3>Add Points</h3></div>
        <div class="module-body">

            <form class="form-horizontal row-fluid" action="<?php echo base_url() . 'Admin/points/add'; ?>" method="post">

                <div class="control-group">
                    <label class="control-label" for="basicinput">Activity Type:</label>
                    <div class="controls">
                        <input name="activity_name" id="activity_name" tabindex="1" data-placeholder="Select here.." class="span8"/>

                        <?php echo form_error('activity_name'); ?>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="basicinput">User Type:</label>
                    <div class="controls">
                        <select name="user_type" id="user_type" tabindex="1" data-placeholder="Select here.." class="span8">
                            <option value="0">-Select-</option>
                            <option value="4">Merchant</option>
                            <option value="5">Customer</option>
                        </select>
                        <?php echo form_error('user_type'); ?>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="basicinput">Activity Points:</label>
                    <div class="controls">

                        <input type="text" name="activity_points" value="" class="span8" />
                        <?php echo form_error('activity_points'); ?>
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