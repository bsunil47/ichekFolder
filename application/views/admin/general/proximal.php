<div class="content">
    <div class="module">
        <div class="module-head">

            <h3>Proximality</h3></div>
        <div class="module-body">
            <form name="contact" method="post" action="" class="form-horizontal row-fluid">

                <div class="control-group">
                    <label class="control-label" for="basicinput">Min Value:</label>
                    <div class="controls">
                        <!--<input type="text" name="column1" value="<?php if (!empty($contact->column1)) echo $contact->column1; ?>" class="span8" />-->
                        <select name="column1" class="span8">
                            <option value="1" <?php if ($contact->column1 == 1) echo "selected"; ?> >1</option>
                            <option value="2" <?php if ($contact->column1 == 2) echo "selected"; ?> >2</option>
                            <option value="3" <?php if ($contact->column1 == 3) echo "selected"; ?> >3</option>
                            <option value="4" <?php if ($contact->column1 == 4) echo "selected"; ?> >4</option>
                            <option value="5" <?php if ($contact->column1 == 5) echo "selected"; ?> >5</option>
                        </select>

                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="basicinput">Max Value:</label>
                    <div class="controls">
<!--<input type="text" name="column2" value="<?php if (!empty($contact->column2)) echo $contact->column2; ?>" class="span8" />-->
                        <select tabindex="1" name="column2" class="span8">
                            <option value="7" <?php if ($contact->column2 == 7) echo "selected"; ?> >7</option>
                            <option value="8" <?php if ($contact->column2 == 8) echo "selected"; ?> >8</option>
                            <option value="9" <?php if ($contact->column2 == 9) echo "selected"; ?> >9</option>
                            <option value="10" <?php if ($contact->column2 == 10) echo "selected"; ?> >10</option>
                            <option value="11" <?php if ($contact->column2 == 11) echo "selected"; ?> >11</option>
                            <option value="12" <?php if ($contact->column2 == 12) echo "selected"; ?>>12</option>
                            <option value="13" <?php if ($contact->column2 == 13) echo "selected"; ?>>13</option>
                            <option value="14" <?php if ($contact->column2 == 14) echo "selected"; ?>>14</option>
                            <option value="15" <?php if ($contact->column2 == 15) echo "selected"; ?>>15</option>
                        </select>
                    </div>
                </div>

                <?php if (!empty($contact)) { ?>
                    <input type="hidden" name="general_id" value="<?php echo $contact->general_id; ?>" class="span8" />
                <?php } ?>

                <div class="control-group">
                    <div class="controls">
<!--                        <input type="submit" name="submit" value="Update" class="btn" />-->

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