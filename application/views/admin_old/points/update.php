<div class="content">
    <div class="module">
        <div class="module-head">

            <h3>Edit Activity Points</h3></div>
        <div class="module-body">
            <form name="update" method="post" action="" class="form-horizontal row-fluid">

                <div class="control-group">
                    <label class="control-label" for="basicinput">Activity Name:</label>
                    <div class="controls">
                        <input name="activity_name" id="activity_name" tabindex="1" data-placeholder="Select here.." value="<?php echo $point->activity_name; ?>" class="span8" disabled/>

                        <?php echo form_error('activity_name'); ?>

                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="basicinput">User Type:</label>
                    <div class="controls">
                        <?php
                        $utype = $point->user_type;
                        if ($utype == 4) {
                            $uname = "Merchant";
                        }
                        if ($utype == 5) {
                            $uname = "Customer";
                        }
                        ?>
                        <select name="user_type" id="user_type" class="span8" disabled>
                            <option value="<?php echo $point->user_type; ?>"><?php echo $uname; ?></option>
                            <?php
                            foreach ($points as $res) {
                                $utype = $res->user_type;
                                if ($utype == 4) {
                                    $uname = "Merchant";
                                }
                                if ($utype == 5) {
                                    $uname = "Customer";
                                }
                                ?>
                                <option value="<?php echo $res->user_type; ?>"><?php echo $uname; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="basicinput">Activity Points:</label>
                    <div class="controls">
                        <input type="text" name="activity_points" value="<?php echo $point->activity_points; ?>" class="span8" />
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
                        <input type="submit" name="submit" value="Edit" class="btn" />
                    </div>
                </div>

            </form>
        </div>
    </div>
    <!--/.module-->
</div>