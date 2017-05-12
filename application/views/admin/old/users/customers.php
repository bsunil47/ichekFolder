<div class="content">
    <div class="module">
        <div class="module-head">

            <h3>Customers List</h3></div>
        <div class="module-body table">

            <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped display" width="100%">

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
                    //if(!empty($customers)) {
                    if (count($customers) != 0) {
                        //foreach($customers as $row)
                        for ($i = 0; $i < count($customers); $i++) {
                            ?>
                            <tr>

                                <td align="left"><?php echo $customers[$i]->firstname; ?></td>
                                <td align="left"><?php echo $customers[$i]->lastname; ?></td>
                                <td align="left"><?php echo $customers[$i]->email; ?></td>
                                <td align="left">
                                    <?php
                                    $status = $customers[$i]->status;
                                    $id = $customers[$i]->id;
                                    if ($status == 1) {
                                        $statusn = "Active";
                                    } else if ($status == 0 || $status == '' || $status == "NULL") {
                                        $statusn = "Inactive";
                                    }
                                    echo $statusn;
                                    ?>

                                </td>
                                <td align="left">

                                    <a href="<?php base_url(); ?>customerstatus/<?php echo $customers[$i]->id; ?>/<?php echo $status; ?>">Status</a>


                                </td>

                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>

                            <td align="left" colspan="5">No customers</td>
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