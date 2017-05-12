<div class="content">
    <div class="module">
        <div class="module-head">
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td align="left"><h3>Terms of Use for Business List</h3></td>

                    <td align="right"><a href="<?php base_url(); ?>toumerchantadd" ><button class='btn' title='Edit' style="border:1px solid #cccccc;">Add Terms of use for Merchant</button></a></td></tr>


            </table>
        </div>
        <div class="module-body table">

            <table cellpadding="0" cellspacing="0" border="0" class=" table table-bordered table-striped display" width="100%">

                <thead>
                    <tr>
                        <th align="left">S.No</th>
                        <th align="left">Heading</th>
                        <th align="left">Terms</th>
                        <th align="left">Status</th>
                        <th align="left">Action</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    //if(!empty($customers)) {
                    if (count($toumerchant) != 0) {
                        //foreach($customers as $row)
                        for ($i = 0; $i < count($toumerchant); $i++) {
                            ?>
                            <tr>

                                <td align="left"><?php
                                    $j = $i + 1;
                                    echo $j;
                                    ?></td>
                                <td align="left"><?php echo $toumerchant[$i]->column1; ?></td>
                                <td align="left"><?php
                                    $ans = substr($toumerchant[$i]->column2, 0, 15);
                                    echo $ans . "..."; //echo $toumerchant[$i]->column2;
                                    ?></td>
                                <td align="left">
                                    <?php
                                    $status = $toumerchant[$i]->status;
                                    $id = $toumerchant[$i]->general_id;
                                    if ($status == 1) {
                                        $statusn = "Active";
                                    } else if ($status == 0 || $status == '' || $status == "NULL") {
                                        $statusn = "Inactive";
                                    }
                                    echo $statusn;
                                    ?>

                                </td>
                                <td align="left">

                                    <a href="<?php base_url(); ?>toumerchantstatus/<?php echo $toumerchant[$i]->general_id; ?>/<?php echo $status; ?>"><button class='btn' title='Edit' style="border:1px solid #cccccc;">Status</button></a>
                                    <a href="<?php base_url(); ?>toumerchantedit/<?php echo $toumerchant[$i]->general_id; ?>"><button class='btn' title='Edit' style="border:1px solid #cccccc;">Edit</button></a>

                                </td>

                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>

                            <td align="left" colspan="5">No Terms of use for Customer</td>
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