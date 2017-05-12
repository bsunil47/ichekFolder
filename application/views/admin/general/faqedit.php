<div class="content">
    <div class="module">
        <div class="module-head">

            <h3>FAQ'S EDIT</h3></div>
        <div class="module-body">
            <form name="contact" method="post" action="" class="form-horizontal row-fluid">
                <div class="control-group">
                    <label class="control-label" for="basicinput">FAQ for:</label>
                    <div class="controls">
                        <!--<input type="text" name="column1" value="<?php if (!empty($contact->column1)) echo $contact->column1; ?>" class="span8" />-->
                        <select name="type" class="span8">
                            <option value="1" <?php if ($faq->type == 1) echo "selected"; ?> >Customer</option>
                            <option value="0" <?php if ($faq->type == 0) echo "selected"; ?> >Business</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="basicinput">Question:</label>
                    <div class="controls">
                        <input type="text" name="column1" value="<?php if (!empty($faq->column1)) echo $faq->column1; ?>" class="span8" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="basicinput">Answer:</label>
                    <div class="controls">
                        <textarea name="column2"  class="span8" > <?php if (!empty($faq->column2)) echo $faq->column2; ?></textarea>
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