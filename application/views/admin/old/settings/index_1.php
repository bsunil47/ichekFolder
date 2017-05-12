<div class="content">
    <div class="module">
        <div class="module-head">
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td align="left"><h3>Settings List</h3></td>
                    <td align="right"><a href="<?php echo $admin_url; ?>/add" ><button class='btn' title='Edit' style="border:1px solid #cccccc;">Add Settings</button></a></td>
                </tr>
            </table>
        </div>
        <div class="module-body table">
            <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped display" width="100%">
                <thead>
                    <tr>
                        <th align="left">Cpc</th>
                        <th align="left">Paypal Id</th>
                        <th align="left">Cashout Min Points</th>
                        <th align="left">cashout Fee</th>
                        <th align="left">Max Cashout</th>
                        <th align="left">Status</th>
                        <th align="left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($settings)) {
                        for ($i = 0; $i < count($settings); $i++) {
                            ?>
                            <tr>

                                <td align="left"><?php echo $settings[$i]->cpc; ?></td>
                                <td align="left"><?php echo $settings[$i]->paypal_id; ?></td>
                                <td align="left"><?php echo $settings[$i]->cashout_min_points; ?></td>
                                <td align="left"><?php echo $settings[$i]->cash_out_fee; ?></td>
                                <td align="left"><?php echo $settings[$i]->max_cash_out; ?></td>
                                <td align="left">
                                    <?php
                                    $status = $settings[$i]->status;
                                    $id = $settings[$i]->icheksetting_id;
                                    if ($status == 1) {
                                        $statusn = "<button class='btn-success' title='Active' style='border:0px solid #cccccc;'>Active</button>";
                                    } else if ($status == 0 || $status == '' || $status == "NULL") {
                                        $statusn = "<button class='btn-danger' title='Inactive' style='border:0px solid #cccccc;'>Inactive</button>";
                                    }
                                    echo $statusn;
                                    ?>
                                </td>

                                <td align="left">
                                    <a href="<?php echo $admin_url; ?>/edit/<?php echo $settings[$i]->icheksetting_id; ?>"><button class='btn' title='Edit' style="border:1px solid #cccccc;">Edit</button></a>

                                    <a href="<?php echo $admin_url; ?>/settingstatus/<?php echo $settings[$i]->icheksetting_id; ?>/<?php echo $settings[$i]->status; ?>"><button class='btn' title='Status' style="border:1px solid #cccccc;">Status</button></a>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr><td align="left" colspan="8">No Settings</td></tr>

                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>