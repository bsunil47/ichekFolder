
<td align="left" width="75%" valign="top">

    <div class="middle_con" align="left">

        <div align="left" class="heading_text">Add Settings</div>

        <div class="dottedline_styles"></div>

        <?php //echo validation_errors(); ?>

        <?php echo form_open(base_url() . 'Admin/settings/add'); ?>

        <table border="0" cellpadding="5" cellspacing="1" width="50%" align="left" class="account_con">


            <tr>

                <td align="right" nowrap="nowrap" class="left_fields">Cpc:</td>
                <td align="left" nowrap="nowrap" >

                    <?php echo form_input('cpc', $this->input->post('cpc'), 'id="cpc", class="right_fields" placeholder="Enter Cpc" autocomplete="off"'); ?>
                    <?php echo form_error('cpc'); ?>
                </td>

            </tr>

            <tr>

                <td align="right" nowrap="nowrap" class="left_fields">Paypal Id:</td>
                <td align="left" nowrap="nowrap" >
                    <?php echo form_input('paypal_id', $this->input->post('paypal_id'), 'id="paypal_id", class="right_fields" placeholder="Enter Paypal Id" autocomplete="off"'); ?>
                    <?php echo form_error('paypal_id'); ?>
                </td>

            </tr>

            <tr>

                <td align="right" nowrap="nowrap" class="left_fields">Cashout Minimum Points:</td>
                <td align="left" nowrap="nowrap" >
                    <?php echo form_input('cashout_min_points', $this->input->post('cashout_min_points'), 'id="cashout_min_points", class="right_fields" placeholder="Enter Cashout Min Points" autocomplete="off"'); ?>
                    <?php echo form_error('cashout_min_points'); ?>
                </td>

            </tr>


            <tr>

                <td align="right" nowrap="nowrap" class="left_fields">Cashout Fee:</td>
                <td align="left" nowrap="nowrap" >
                    <?php echo form_input('cash_out_fee', $this->input->post('cash_out_fee'), 'id="cash_out_fee", class="right_fields" placeholder="Enter Cashout Fee" autocomplete="off"'); ?>
                    <?php echo form_error('cash_out_fee'); ?>
                </td>

            </tr>

            <tr>

                <td align="right" nowrap="nowrap" class="left_fields">Maximum Cashout:</td>
                <td align="left" nowrap="nowrap" >
                    <?php echo form_input('max_cash_out', $this->input->post('max_cash_out'), 'id="max_cash_out", class="right_fields" placeholder="Enter Maximum Cashout" autocomplete="off"'); ?>
                    <?php echo form_error('max_cash_out'); ?>
                </td>

            </tr>

            <tr>

                <td align="right" nowrap="nowrap" class="left_fields">status:</td>
                <td align="left" nowrap="nowrap" >

                    <select name="status" id="status" class="right_fields">
                        <option name="">-Select-</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                    <?php echo form_error('status'); ?>
                </td>

            </tr>


            <tr>

                <td align="center" nowrap="nowrap" class="left_fields" colspan="3">
                    <?php echo form_submit('submit', 'Add', 'id="submit"', 'name="submit"'); ?>

                </td>

            </tr>

        </table>

        <?php echo form_close(); ?>



    </div>


</td>


</tr>
</table>


</td>
<td align="left" style="width:15%;"></td>

</tr>
</table>
</div>