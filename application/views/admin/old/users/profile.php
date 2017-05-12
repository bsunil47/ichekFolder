<div class="content">
    <div class="module">
        <div class="module-head">

            <h3>Edit Admin Profile</h3></div>
        <div class="module-body">
            <form name="updateadmin" method="post" action="" class="form-horizontal row-fluid">
                <div class="control-group">
                    <label class="control-label" for="basicinput">First Name:</label>
                    <div class="controls">
                        <input type="text" name="firstname" value="<?php echo $users->firstname; ?>" class="span8" />
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="basicinput">Last Name:</label>
                    <div class="controls"><input type="text" name="lastname" value="<?php echo $users->lastname; ?>" class="span8" />
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="basicinput">Phone:</label>
                    <div class="controls"><input type="text" name="phone" value="<?php echo $users->phone; ?>" class="span8" />
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="basicinput">Address:</label>
                    <div class="controls"><textarea name="address" cols="22" rows="2" class="span8"><?php echo $users->address; ?></textarea>
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls"><input type="submit" name="submit" value="Edit" class="btn" /></div>
                </div>

            </form>
        </div>
    </div>
    <!--/.module-->
</div>