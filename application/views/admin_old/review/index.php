<td align="left" width="75%" valign="top">

    <div class="middle_con" align="left">

        <div align="left" class="heading_text">Reviews</div>

        <div class="dottedline_styles"></div>

        <div class="row-fluid">

            <div class="span12 tac">
                <table border="1" cellpadding="5" cellspacing="0" width="600" align="center" class="tablenew">

                    <tr>
                        <th align="left">Merchant Name</th>
                        <th align="left">Customer Name</th>
                        <th align="left">Review</th>
                        <th align="left">Status</th>
                        <th align="left">Action</th>
                    </tr>

                    <?php
                    if (!empty($reviews)) {
                        // print_r(count($users));
                        //foreach($users as $row)
                        for ($i = 0; $i < count($reviews); $i++) {
                            ?>
                            <tr>

                                <td align="left"><?php echo $reviews[$i]->id_merchant; ?></td>
                                <td align="left"><?php echo $reviews[$i]->id_customer; ?></td>
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
                    } else {
                        ?>
                        <tr>

                            <td align="left" colspan="5">No Reviews</td>
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