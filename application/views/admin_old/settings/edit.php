
<td align="left" width="75%" valign="top">

    <div class="middle_con" align="left">

        <div align="left" class="heading_text">Edit User</div>

        <div class="dottedline_styles"></div>


        <form name="editsettings" method="post" action="">


            <table border="0" cellpadding="5" cellspacing="1" width="50%" align="left" class="account_con">


                <tr>

                    <td align="right" nowrap="nowrap" class="left_fields">Cpc:</td>
                    <td align="left" nowrap="nowrap" ><input type="text" name="cpc" value="<?php echo $settings->cpc; ?>" class="right_fields" />
                    </td>

                </tr>

                <tr>

                    <td align="right" nowrap="nowrap" class="left_fields">Paypal Id:</td>
                    <td align="left" nowrap="nowrap" ><input type="text" name="paypal_id" value="<?php echo $settings->paypal_id; ?>" class="right_fields" /></td>

                </tr>

                <tr>

                    <td align="right" nowrap="nowrap" class="left_fields">Cashout Minimum Points:</td>
                    <td align="left" nowrap="nowrap" ><input type="text" name="cashout_min_points" value="<?php echo $settings->cashout_min_points; ?>" class="right_fields" /></td>

                </tr>


                <tr>

                    <td align="right" nowrap="nowrap" class="left_fields">Cashout Fee:</td>
                    <td align="left" nowrap="nowrap" ><input type="text" name="cash_out_fee" value="<?php echo $settings->cash_out_fee; ?>" class="right_fields" /></td>

                </tr>

                <tr>

                    <td align="right" nowrap="nowrap" class="left_fields">Maximum Cashout:</td>
                    <td align="left" nowrap="nowrap" ><input type="text" name="max_cash_out" value="<?php echo $settings->max_cash_out; ?>" class="right_fields" /></td>

                </tr>

                <td align="center" nowrap="nowrap" class="left_fields" colspan="3"><input type="submit" name="submit" value="Edit" class="btn-success" /></td>

                </tr>

            </table>

        </form>



    </div>


</td>


</tr>
</table>


</td>
<td align="left" style="width:15%;"></td>

</tr>
</table>
</div>