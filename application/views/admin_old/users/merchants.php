<td align="left" width="75%" valign="top">

    <div class="middle_con" align="left">

        <div align="left" class="heading_text">Merchantslist</div>

        <div class="dottedline_styles"></div>

        <div class="row-fluid">

            <div class="span12 tac">



                <table border="0" cellpadding="5" cellspacing="0" width="600" align="center" class="tablenew">

                    <tr>
                        <th align="left">First Name</th>
                        <th align="left">Last Name</th>
                        <th align="left">Email</th>
                        <th align="left">Status</th>
                        <th align="left">Action</th>

                    </tr>
                    <?php
                    if (!empty($merchants)) {
                        //foreach($merchants as $row)
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
                                        $statusn = "Active";
                                    } else if ($status == 0 || $status == '' || $status == "NULL") {
                                        $statusn = "Inactive";
                                    }
                                    echo $statusn;
                                    ?>

                                </td>
                                <td align="left">

                                    <a href="<?php base_url(); ?>merchantstatus/<?php echo $merchants[$i]->id; ?>/<?php echo $status; ?>">Status</a>


                                </td>

                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>

                            <td align="left" colspan="5">No merchants</td>
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