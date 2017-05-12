<div class="content">
    <div class="module">
        <div class="module-head"> <h3>Edit User</h3></div>
        <div class="module-body">
            <form name="updateuser" method="post" action="" class="form-horizontal row-fluid">
                <div class="control-group">
                    <label class="control-label" for="basicinput">First Name:</label>
                    <div class="controls">
                        <input type="text" name="firstname" value="<?php echo $users->firstname; ?>" class="right_fields" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="basicinput">Last Name:</label>
                    <div class="controls">
                        <input type="text" name="lastname" value="<?php echo $users->lastname; ?>" class="right_fields" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="basicinput">Email:</label>
                    <div class="controls">
                        <input type="text" name="email" value="<?php echo $users->email; ?>" class="right_fields" />
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