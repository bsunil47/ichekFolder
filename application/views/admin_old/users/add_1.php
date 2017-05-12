
<td align="left" width="75%" valign="top">

    <div class="middle_con" align="left">

        <div align="left" class="heading_text">Add User</div>

        <div class="dottedline_styles"></div>

        <?php //echo validation_errors(); ?>

        <?php echo form_open(base_url() . 'Admin/users/add'); ?>

        <table border="0" cellpadding="5" cellspacing="1" width="50%" align="left" class="account_con">


            <tr>

                <td align="right" nowrap="nowrap" class="left_fields">First Name:</td>
                <td align="left" nowrap="nowrap" >

                    <?php echo form_input('firstname', $this->input->post('firstname'), 'id="firstname", class="right_fields" placeholder="Enter First Name" autocomplete="off"'); ?>
                    <?php echo form_error('firstname'); ?>
                </td>

            </tr>

            <tr>

                <td align="right" nowrap="nowrap" class="left_fields">Last Name:</td>
                <td align="left" nowrap="nowrap" >
                    <?php echo form_input('lastname', $this->input->post('lastname'), 'id="lastname", class="right_fields" placeholder="Enter Last Name" autocomplete="off"'); ?>
                    <?php echo form_error('lastname'); ?>
                </td>

            </tr>

            <tr>

                <td align="right" nowrap="nowrap" class="left_fields">Email:</td>
                <td align="left" nowrap="nowrap" >
                    <?php echo form_input('email', $this->input->post('email'), 'id="email", class="right_fields" placeholder="Enter Email" autocomplete="off"'); ?>
                    <?php echo form_error('email'); ?>
                </td>

            </tr>


            <tr>

                <td align="right" nowrap="nowrap" class="left_fields">Phone:</td>
                <td align="left" nowrap="nowrap" >
                    <?php echo form_input('phone', $this->input->post('phone'), 'id="phone", class="right_fields" placeholder="Enter Phone" autocomplete="off"'); ?>
                    <?php echo form_error('phone'); ?>
                </td>

            </tr>

            <tr>

                <td align="right" nowrap="nowrap" class="left_fields">User Type:</td>
                <td align="left" nowrap="nowrap" >

                    <select name="status" id="status" class="right_fields">
                        <option name="">-Select-</option>
                        <option value="2">Finance Admin</option>
                        <option value="3">Account Admin</option>
                    </select>
                    <?php echo form_error('status'); ?>
                </td>

            </tr>

            <tr>

                <td align="right" nowrap="nowrap" class="left_fields">Address:</td>
                <td align="left" nowrap="nowrap" >
                    <?php echo form_textarea('address', $this->input->post('address'), 'id="address", class="right_fields" placeholder="Enter Address" autocomplete="off"'); ?>
                    <?php echo form_error('address'); ?>

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