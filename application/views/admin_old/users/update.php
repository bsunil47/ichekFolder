
<td align="left" width="75%" valign="top">

    <div class="middle_con" align="left">

        <div align="left" class="heading_text">Edit User</div>

        <div class="dottedline_styles"></div>


        <form name="updateuser" method="post" action="">


            <table border="0" cellpadding="5" cellspacing="1" width="50%" align="left" class="account_con">


                <tr>

                    <td align="right" nowrap="nowrap" class="left_fields">First Name:</td>
                    <td align="left" nowrap="nowrap" ><input type="text" name="firstname" value="<?php echo $users->firstname; ?>" class="right_fields" />
                    </td>

                </tr>

                <tr>

                    <td align="right" nowrap="nowrap" class="left_fields">Last Name:</td>
                    <td align="left" nowrap="nowrap" ><input type="text" name="lastname" value="<?php echo $users->lastname; ?>" class="right_fields" /></td>

                </tr>

                <tr>

                    <td align="right" nowrap="nowrap" class="left_fields">Email:</td>
                    <td align="left" nowrap="nowrap" ><input type="text" name="email" value="<?php echo $users->email; ?>" class="right_fields" /></td>

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