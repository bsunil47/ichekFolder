<div class="content">
    <div class="module">
        <div class="module-head">

            <h3>Edit Settings</h3></div>
        <div class="module-body">
            <form name="editsettings" method="post" action="" class="form-horizontal row-fluid">

                <div class="control-group">
                    <label class="control-label" for="basicinput">Cpc:</label>
                    <div class="controls">
                        <input type="text" name="cpc" value="<?php echo $settings->cpc; ?>" class="span8" />
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="basicinput">Paypal Id:</label>
                    <div class="controls">
                        <input type="text" name="paypal_id" value="<?php echo $settings->paypal_id; ?>" class="span8" />

                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="basicinput">Cashout Minimum Points:</label>
                    <div class="controls">
                        <input type="text" name="cashout_min_points" value="<?php echo $settings->cashout_min_points; ?>" class="span8" />
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="basicinput">Cashout Fee:</label>
                    <div class="controls">
                        <input type="text" name="cash_out_fee" value="<?php echo $settings->cash_out_fee; ?>" class="span8" />
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="basicinput">Maximum Cashout:</label>
                    <div class="controls">
                        <input type="text" name="max_cash_out" value="<?php echo $settings->max_cash_out; ?>" class="span8" />
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