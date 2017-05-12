<div class="content">
    <div class="module">
        <div class="module-head"><h3>Edit Reported Review</h3></div>
        <div class="module-body">
            <form id="updatereport" name="updatereport" method="post" action="" class="form-horizontal row-fluid">
                <div class="control-group">
                    <label class="control-label" for="basicinput">Review Message:</label>
                    <div class="controls"><textarea name="review" cols="40" rows="4" class="span8"><?php echo json_decode('"'.$reports->review.'"'); ?></textarea></div>
                </div>
                <div class="control-group">
                    <div class="controls"><input type="submit" name="submit" value="Save" class="btn" /></div>
                </div>
            </form>
        </div>
    </div>
</div>