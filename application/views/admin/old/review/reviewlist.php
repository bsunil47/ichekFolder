<div class="content">
    <div class="module">
        <div class="module-head">

            <h3>Reviews</h3></div>
        <div class="module-body table">
            <?php
            if (!empty($reviews)) {
                ?>
                <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped display" width="100%">

                    <thead>
                        <tr>
                            <th align="left">Merchant Name</th>
                            <th align="left">Customer Name</th>
                            <th align="left">Review</th>
                            <th align="left">Status</th>
                            <th align="left">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //foreach($users as $row)
                        for ($i = 0; $i < count($reviews); $i++) {
                            ?>
                            <tr>

                                <td align="left"><?php echo $reviews[$i]->business_name; ?></td>
                                <td align="left"><?php echo $reviews[$i]->firstname; ?></td>
                                <td align="left"><?php echo $reviews[$i]->review; ?></td>

                                <td align="left">
                                    <?php
                                    $status = $reviews[$i]->status;
                                    $id = $reviews[$i]->id;
                                    if ($status == 1) {
                                        $statusn = "Active";
                                    } else if ($status == 0 || $status == '' || $status == "NULL") {
                                        $statusn = "Inactive";
                                    }
                                    echo $statusn;
                                    ?>

                                </td>

                                <td align="left">
                                    <a href="<?php base_url(); ?>edit/<?php echo $reviews[$i]->id; ?>">Edit</a>
                                    <img src="<?php echo base_url(); ?>images/divid.gif" border="0" alt="divid" />
                                    <a href="<?php base_url(); ?>reviewstatus/<?php echo $reviews[$i]->id; ?>/<?php echo $reviews[$i]->status; ?>">Status</a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
                <?php
            } else {


                echo "<div align='center'>No Reviews</div>";
            }
            ?>

        </div>
    </div>
    <!--/.module-->
</div>