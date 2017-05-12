<td align="left" width="75%" valign="top">

    <div class="middle_con" align="left">

        <div align="left" class="heading_text">Userslist</div>

        <div class="dottedline_styles"></div>

        <div class="row-fluid">

            <div class="span12 tac">

                <?php //echo base_url(); ?>

                <table border="1" cellpadding="5" cellspacing="0" width="600" align="center" class="tablenew">
                    <tr>

                        <td align="right" colspan="5"><a href="<?php base_url(); ?>add" class="btn-success">Add User</a></td></tr>

                    <tr>
                        <th align="left">First Name</th>
                        <th align="left">Last Name</th>
                        <th align="left">Email</th>
                        <th align="left">Status</th>
                        <th align="left">Action</th>
                    </tr>
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
                </table>

            </div>

        </div>



    </div>


</td>


</tr>
</table>


</td>
<td align="left" style="width:15%;"></td>

</tr>
</table>
</div>