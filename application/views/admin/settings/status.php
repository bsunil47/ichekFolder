<div class="content">
    <div class="module">
        <div class="module-head">
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td align="left"><h3>Status Management  List</h3></td>
                    <td align="right"><a href="<?php base_url(); ?>addstatus" ><button class='btn' title='Edit' style="border:1px solid #cccccc;">Add Status</button></a></td>
                </tr>
            </table>
        </div>
        <div class="module-body table">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped display" width="100%">
                <thead>
                    <tr>
                        <th align="left">S.NO</th>
                        <th align="left">Status Name</th>
                        <th align="left">Points</th>
<!--                        <th align="left">Status</th>-->
                        <th align="left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($settings)) {
                        //foreach($users as $row)

                        for ($i = 0, $j = 1; $i < count($settings); $i++, $j++) {
                            ?>
                            <tr>

                                <td align="left"><?php echo $j; ?></td>
                                <td align="left"><?php echo $settings[$i]->name; ?></td>
                                <td align="left"><?php echo $settings[$i]->points; ?></td>
        <!--                                <td align="left">
                                <?php
                                // $status = $settings[$i]->status;
                                // $id = $settings[$i]->id;
                                // if ($status == 1) {
                                //     $statusn = "Active";
                                // } else if ($status == 0 || $status == '' || $status == "NULL") {
                                //    $statusn = "Inactive";
                                //}
                                // echo $statusn;
                                ?>

                                </td>-->

                                <td align="left">
                                    <a href="<?php base_url(); ?>statusedit/<?php echo $settings[$i]->points_status_id; ?>"><button class='btn' title='Edit' style="border:1px solid #cccccc;">Edit</button></a>

                                    <a href="<?php base_url(); ?>statstatus/<?php echo $settings[$i]->points_status_id; ?>/<?php echo $settings[$i]->status; ?>"><button class='btn' title='status' style="border:1px solid #cccccc;">Status</button></a>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>

                            <td align="left" colspan="8">No Records Found</td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>

            </table>
        </div>
    </div>
</div>

