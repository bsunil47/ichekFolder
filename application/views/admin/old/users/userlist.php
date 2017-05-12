<div class="content">
    <div class="module">
        <div class="module-head">

            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td align="left"><h3>Users List</h3></td>

                    <td align="right"><a href="<?php base_url(); ?>add" >Add User</a></td></tr>


            </table></div>
        <div class="module-body table">


            <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display" width="100%">
                                       <!-- <tr>

                          <td align="right" colspan="5"><a href="<?php //base_url();     ?>add" class="btn-success">Add User</a></td></tr>
                -->
                <thead>
                    <tr>

                        <th align="left">First Name</th>
                        <th align="left">Last Name</th>
                        <th align="left">Email</th>
                        <th align="left">Status</th>
                        <th align="left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($users)) {
                        // print_r(count($users));
                        //foreach($users as $row)
                        for ($i = 0; $i < count($users); $i++) {
                            ?>
                            <tr>

                                <td align="left"><?php echo $users[$i]->firstname; ?></td>
                                <td align="left"><?php echo $users[$i]->lastname; ?></td>
                                <td align="left"><?php echo $users[$i]->email; ?></td>
                                <td align="left">
                                    <?php
                                    $status = $users[$i]->status;
                                    $id = $users[$i]->id;
                                    if ($status == 1) {
                                        $statusn = "Active";
                                    } else if ($status == 0 || $status == '' || $status == "NULL") {
                                        $statusn = "Inactive";
                                    }
                                    echo $statusn;
                                    ?>

                                </td>

                                <td align="left">
                                    <a href="<?php base_url(); ?>update/<?php echo $users[$i]->id; ?>">Edit</a>
                                    <img src="<?php echo base_url(); ?>images/divid.gif" border="0" alt="divid" />
                                    <a href="<?php base_url(); ?>userstatus/<?php echo $users[$i]->id; ?>/<?php echo $status; ?>">Status</a>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>

                            <td align="left" colspan="5">No Users</td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>

            </table>
        </div>
    </div>
    <!--/.module-->
</div>

