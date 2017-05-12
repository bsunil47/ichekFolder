<td align="left" width="75%" valign="top">

    <div class="middle_con" align="left">

        <div align="left" class="heading_text">Settings List</div>

        <div class="dottedline_styles"></div>

        <div class="row-fluid">

            <div class="span12 tac">

                <?php //echo base_url(); ?>

                <table border="1" cellpadding="5" cellspacing="0" width="600" align="center" class="tablenew">

                    <tr>
                        <th align="left">Cpc</th>
                        <th align="left">Paypal Id</th>
                        <th align="left">Cashout Min Points</th>
                        <th align="left">cashout Fee</th>
                        <th align="left">Max Cashout</th>
                        <th align="left">Status</th>
                        <th align="left">Action</th>
                    </tr>
                    <?php
                    if (!empty($settings)) {
                        // print_r(count($users));
                        //foreach($users as $row)
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
                                        $statusn = "Active";
                                    } else if ($status == 0 || $status == '' || $status == "NULL") {
                                        $statusn = "Inactive";
                                    }
                                    echo $statusn;
                                    ?>

                                </td>

                                <td align="left">
                                    <a href="<?php base_url(); ?>edit/<?php echo $settings[$i]->icheksetting_id; ?>">Edit</a>
                                    <img src="<?php echo base_url(); ?>images/divid.gif" border="0" alt="divid" />
                                    <a href="<?php base_url(); ?>settingstatus/<?php echo $settings[$i]->icheksetting_id; ?>/<?php echo $settings[$i]->status; ?>">Status</a>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>

                            <td align="left" colspan="5">No Settings</td>
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