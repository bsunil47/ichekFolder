<div class="content">
    <div class="module">
        <div class="module-head"><h3>Merchants List&nbsp;</h3> </div>
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
                    if (count($merchants) != 0) {
                        for ($i = 0; $i < count($merchants); $i++) {
                            ?>
                            <tr>
                                <td align="left"><?php echo $merchants[$i]->firstname; ?></td>
                                <td align="left"><?php echo $merchants[$i]->lastname; ?></td>
                                <td align="left"><?php echo $merchants[$i]->email; ?></td>
                                <td align="left">
                                    <?php
                                    $status = $merchants[$i]->status;
                                    $id = $merchants[$i]->id;
                                    if ($status == 1) {
                                        $statusn = "<button class='btn-success' title='Active' style='border:0px solid #cccccc;'>Active</button>";
                                    } else if ($status == 0 || $status == '' || $status == "NULL") {
                                        $statusn = "<button class='btn-danger' title='Inactive' style='border:0px solid #cccccc;'>Inactive</button>";
                                    }
                                    echo $statusn;
                                    ?>
                                </td>
                                <td align="left"><a href="<?php base_url(); ?>merchantstatus/<?php echo $merchants[$i]->id; ?>/<?php echo $status; ?>"><button class='btn' title='Status' style="border:1px solid #cccccc;">Status</button></a></td>

                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td align="left" colspan="6">No merchants</td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>