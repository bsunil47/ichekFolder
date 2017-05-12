<td align="left" width="75%" valign="top">
    <div class="middle_con" align="left">
        <div align="left" class="heading_text">Dashboard</div>
        <div class="dottedline_styles"></div>
        <div class="row-fluid">
            <div class="span12 tac">
                <ul class="ov_boxes">
                    <li style="float:left; width:215px;">
                        <div class="p_bar_up p_canvas"><img src="<?php echo base_url(); ?>images/canvas.png" ></div>
                        <div class="ov_text">
                            <strong><a href="<?php echo base_url(); ?>Admin/users/userlist" style="text-decoration:none;"><?php echo $users->count; ?></a></strong>
                            Users
                        </div>
                    </li>
                    <li style="float:left; width:225px;">
                        <div class="p_bar_down p_canvas"><img src="<?php echo base_url(); ?>images/canvas1.png"></div>
                        <div class="ov_text">
                            <strong><a href="<?php echo base_url(); ?>Admin/users/merchants" style="text-decoration:none;"><?php echo $merchant->count; ?></a></strong>
                            Merchants
                        </div>
                    </li>
                    <li style="float:left; width:215px;">
                        <div class="p_line_up p_canvas"><img src="<?php echo base_url(); ?>images/canvas3.png"></div>
                        <div class="ov_text">
                            <strong><a href="<?php echo base_url(); ?>Admin/users/customers" style="text-decoration:none;"><?php echo $customers->count; ?></a></strong>
                            Customers
                        </div>
                    </li>
                    <li style="float:left; width:215px;">
                        <div class="p_line_up p_canvas"><img src="<?php echo base_url(); ?>images/canvas4.png"></div>
                        <div class="ov_text">
                            <strong></strong>
                            Others
                        </div>
                    </li>
                </ul>
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