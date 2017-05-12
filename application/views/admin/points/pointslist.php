<div class="content">
    <div class="module">
        <div class="module-head">

            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td align="left"><h3>Points</h3></td>

<!--                    <td align="right"><a href="<?php base_url(); ?>add" >Add Points</a></td>--></tr>


            </table></div>
        <div class="module-body table">

            <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped display" width="100%">

                <thead>
                    <tr>
                        <th align="left">Activity Name</th>
                        <th align="left">Activity Points</th>
                        <th align="left">User Type</th>
                        <th align="left">Status</th>
                        <th align="left">Action</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($points)) {
                        //foreach($merchants as $row)
                        for ($i = 0; $i < count($points); $i++) {
                            ?>
                            <tr>

                                <td align="left"><?php echo $points[$i]->activity_name; ?></td>
                                <td align="left"><?php echo $points[$i]->activity_points; ?></td>
                                <td align="left">
                                    <?php
                                    $user = $points[$i]->user_type;
                                    if ($user == 4) {
                                        $usertype = "Merchant";
                                    }
                                    if ($user == 5) {
                                        $usertype = "Customer";
                                    }
                                    echo $usertype;
                                    ?>
                                </td>
                                <td align="left">
                                    <?php
                                    $status = $points[$i]->status;
                                    $id = $points[$i]->id;
                                    if ($status == 1) {
                                        $statusn = "Active";
                                    } else if ($status == 0 || $status == '' || $status == "NULL") {
                                        $statusn = "Inactive";
                                    }
                                    echo $statusn;
                                    ?>

                                </td>
                                <td align="left">
                                    <a href="<?php base_url(); ?>update/<?php echo $points[$i]->id; ?>">Edit</a>
                                    <img src="<?php echo base_url(); ?>images/divid.gif" border="0" alt="divid" />
                                    <a href="<?php base_url(); ?>pointsstatus/<?php echo $points[$i]->id; ?>/<?php echo $status; ?>">Status</a>

                                </td>

                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>

                            <td align="left" colspan="6">No Data</td>
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