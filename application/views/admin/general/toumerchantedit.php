<div class="content">
    <div class="module">
        <div class="module-head">

            <h3>Terms of Business EDIT</h3></div>
        <div class="module-body">
            <form name="contact" method="post" action="" class="form-horizontal row-fluid">

                <div class="control-group">
                    <label class="control-label" for="basicinput">Heading:</label>
                    <div class="controls">
                        <input type="text" name="column1" value="<?php if (!empty($toumerchant->column1)) echo $toumerchant->column1; ?>" class="span8" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="basicinput">terms:</label>
                    <div class="controls">
                        <textarea name="column2"  class="span8" > <?php if (!empty($toumerchant->column2)) echo $toumerchant->column2; ?></textarea>
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
                        <input type="submit" name="submit" value="Update" class="btn" />

                    </div>
                </div>

            </form>
        </div>
    </div>
    <!--/.module-->
</div>