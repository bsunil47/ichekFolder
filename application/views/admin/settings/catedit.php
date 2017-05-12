<div class="content">
    <div class="module">
        <div class="module-head"> <h3>Edit Category</h3></div>
        <div class="module-body">
            <form id ="editcat" name="editcat" method="post" action="" class="form-horizontal row-fluid">
                <div class="control-group">
                    <label class="control-label" for="basicinput">Category:</label>
                    <div class="controls">
                        <input type="text" name="name" value="<?php echo $settings->name; ?>" class="span8" />
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
</div>