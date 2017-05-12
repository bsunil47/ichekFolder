<div class="content">
    <div class="module">
        <div class="module-head">

            <h3>Contact Details</h3></div>
        <div class="module-body">
            <form name="contact" method="post" action="" class="form-horizontal row-fluid">

                <div class="control-group">
                    <label class="control-label" for="basicinput">Email:</label>
                    <div class="controls">
                        <input type="text" name="column1" value="<?php if (!empty($contact->column1)) echo $contact->column1; ?>" class="span8" />
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="basicinput">Phone:</label>
                    <div class="controls">
                        <input type="text" name="column3" value="<?php if (!empty($contact->column3)) echo $contact->column3; ?>" class="span8" />

                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="basicinput">Address:</label>
                    <div class="controls">
                        <textarea name="column2"  class="span8" > <?php if (!empty($contact->column2)) echo $contact->column2; ?></textarea>
                        <?php if (!empty($contact)) { ?>
                            <input type="hidden" name="general_id" value="<?php echo $contact->general_id; ?>" class="span8" />
                        <?php } ?>
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