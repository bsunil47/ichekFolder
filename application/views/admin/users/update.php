<div class="content">
    <div class="module">
        <div class="module-head"> <h3>Edit User</h3></div>
        <div class="module-body">
            <form id="updateadminuser" name="updateadminuser" method="post" action="" class="form-horizontal row-fluid">
                <div class="control-group">
                    <label class="control-label" for="firstname">First Name:</label>
                    <div class="controls">
                        <input type="text" name="firstname" id="firstname" value="<?php echo $users->firstname; ?>" class="right_fields" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="lastname">Last Name:</label>
                    <div class="controls">
                        <input type="text" name="lastname" id="lastname" value="<?php echo $users->lastname; ?>" class="right_fields" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="email">Email:</label>
                    <div class="controls">
                        <input type="text" name="email" id="email" value="<?php echo $users->email; ?>" class="right_fields" />
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