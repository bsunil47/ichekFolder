<div class="content">
    <div class="module">
        <div class="module-head">
            <h3>Reported Reviews</h3></div>
        <div class="module-body table">
            <?php
            if (!empty($reports)) {
                ?>
                <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped display" width="100%">
                    <thead>
                        <tr>

                            <th align="left">Customer Name</th>
                            <th align="left">Merchant</th>
                            <th align="left">Review</th>
                            <th align="left">Status</th>
                            <th align="left">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for ($i = 0; $i < count($reports); $i++) {
                            ?>
                            <tr>
                                <?php
                                $merchat_pic = "";
                                $customer_pic = "";
                                if(file_exists(base_url().$reports[$i]->id_merchant.'/assert.jpg')){
                                    $merchat_pic = base_url().$reports[$i]->id_merchant.'/assert.jpg';
                                }elseif(!empty($reports[$i]->merchant_facebook_id)){
                                    $merchat_pic = "http://graph.facebook.com/{$reports[$i]->merchant_facebook_id}/picture?type=normal";
                                }else{
                                    $merchat_pic = base_url().'images/user.png';
                                }

                                if(file_exists(base_url().$reports[$i]->id_customer.'/assert.jpg')){
                                    $customer_pic = base_url().$reports[$i]->id_customer.'/assert.jpg';
                                }elseif(!empty($reports[$i]->customer_facebook_id)){
                                    $customer_pic = "http://graph.facebook.com/{$reports[$i]->customer_facebook_id}/picture?type=normal";
                                }else{
                                    $customer_pic = base_url().'images/user.png';
                                }

                                ?>
                                <td align="left"><span onclick="popupDiv(this)" style="cursor: pointer; text-decoration: underline" class="popup_display" data-image_url="<?php echo $customer_pic; ?>" data-usertype="5" data-title="Customer Details" data-mobile="<?php echo $reports[$i]->customer_mobile; ?>" data-email="<?php echo $reports[$i]->customer_email; ?>" data-name="<?php echo $reports[$i]->firstname . ' ' . $reports[$i]->lastname;?>"><?php echo $reports[$i]->firstname . ' ' . $reports[$i]->lastname;?></span></td>
                                <td align="left"><span onclick="popupDiv(this)" style="cursor: pointer; text-decoration: underline" class="popup_display" data-image_url="<?php echo $merchat_pic; ?>" data-usertype="4" data-title="Merchant Details" data-mobile="<?php echo $reports[$i]->merchant_mobile; ?>" data-email="<?php echo $reports[$i]->merchant_email; ?>" data-name="<?php echo $reports[$i]->merchant_firstname . ' ' . $reports[$i]->merchant_lastname;?>" data-business_name="<?php echo $reports[$i]->display_name; ?>"><?php echo $reports[$i]->display_name; ?></span></td>
                                <?php $encoding = ini_get('mbstring.internal_encoding'); ?>
                                <td align="left"><?php echo json_decode('"'.$reports[$i]->review.'"') ?><?php //echo preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/u', function($match) use ($encoding) {
                                        //return mb_convert_encoding(pack('H*', $match[1]), $encoding, 'UTF-16BE');
                                   // }, $reports[$i]->review); ?></td>
                                <td align="left">
                                    <?php
                                    $status = $reports[$i]->status;
                                    $id = $reports[$i]->review_messages_id;
                                    if ($status == 1) {
                                        $statusn = "<button class='btn-success' title='Active' style='border:0px solid #cccccc;'>Reviewed</button>";
                                    } else if ($status == 0 || $status == '' || $status == "NULL") {
                                        $statusn = "<button class='btn-info' title='Inactive' style='border:0px solid #cccccc;'>Review</button>";
                                    } else if ($status == 2) {
                                        $statusn = "<button class='btn-danger'  style='border:0px solid #cccccc;'>Reported</button>";
                                    }
                                    echo $statusn;
                                    ?>
                                </td>
                                <td align="left">
                                    <a href="<?php echo $admin_url; ?>/reportsedit/<?php echo $reports[$i]->review_messages_id; ?>"><button class='btn' title='Status' style="border:1px solid #cccccc;">Edit</button></a>
                                    <a href="<?php echo $admin_url; ?>/reviewstatus/<?php echo $reports[$i]->id; ?>/<?php echo $status; ?>"><button class='btn' title='Status' style="border:1px solid #cccccc;">Move to reviews</button></a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
                <?php
            } else {
                echo "<div align='center'>No Reported Reviews</div>";
            }
            ?>
        </div>
    </div>
</div>