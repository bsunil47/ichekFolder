<div class="content">
    <div class="module">
        <div class="module-head">
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td align="left"><h3>View Merchant</h3></td>
                </tr>
            </table>
        </div>
        <div class="module-body table">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped" width="100%">

                <tbody>

                    <?php
                    if (!empty($merchantsuploadlist)) {
                        ?>
                        <?php if (!empty($merchantsuploadlist->title)) { ?><tr><th align="right">Title:</th><td align="left"><?php echo $merchantsuploadlist->title; ?></td></tr><?php } ?>
                        <?php if (!empty($merchantsuploadlist->business_logo_url)) { ?><tr><th align="right">Business Logo URL:</th><td align="left"><?php echo $merchantsuploadlist->business_logo_url; ?></td></tr><?php } ?>
                        <?php if (!empty($merchantsuploadlist->address)) { ?><tr><th align="right">Address:</th><td align="left"><?php echo $merchantsuploadlist->address; ?></td></tr><?php } ?>
                        <?php if (!empty($merchantsuploadlist->city)) { ?><tr><th align="right">City:</th><td align="left"><?php echo $merchantsuploadlist->city; ?></td></tr><?php } ?>
                        <?php if (!empty($merchantsuploadlist->state)) { ?><tr><th align="right">State:</th><td align="left"><?php echo $merchantsuploadlist->state; ?></td></tr><?php } ?>
                        <?php if (!empty($merchantsuploadlist->phone)) { ?><tr><th align="right">Phone:</th><td align="left"><?php echo $merchantsuploadlist->phone; ?></td></tr><?php } ?>
                        <?php if (!empty($merchantsuploadlist->business_img_url1)) { ?><tr><th align="right">Business Image URL1:</th><td align="left"><?php echo $merchantsuploadlist->business_img_url1; ?></td></tr><?php } ?>
                        <?php if (!empty($merchantsuploadlist->username)) { ?><tr><th align="right">User Name:</th><td align="left"><?php echo $merchantsuploadlist->username; ?></td></tr><?php } ?>
                        <?php if (!empty($merchantsuploadlist->business_name)) { ?><tr><th align="right">Business Name:</th><td align="left"><?php echo $merchantsuploadlist->business_name; ?></td></tr><?php } ?>
                        <?php if (!empty($merchantsuploadlist->display_name)) { ?><tr><th align="right">Display Name:</th><td align="left"><?php echo $merchantsuploadlist->display_name; ?></td></tr><?php } ?>
                        <?php if (!empty($merchantsuploadlist->location)) { ?><tr><th align="right">Location:</th><td align="left"><?php echo $merchantsuploadlist->location; ?></td></tr><?php } ?>
                        <?php if (!empty($merchantsuploadlist->rating)) { ?><tr><th align="right">Rating:</th><td align="left"><?php echo $merchantsuploadlist->rating; ?></td></tr><?php } ?>
                        <?php if (!empty($merchantsuploadlist->reviews)) { ?><tr><th align="right">Review:</th><td align="left"><?php echo $merchantsuploadlist->reviews; ?></td></tr><?php } ?>
                        <?php if (!empty($merchantsuploadlist->category)) { ?><tr><th align="right">Category:</th><td align="left"><?php echo $merchantsuploadlist->category; ?></td></tr><?php } ?>


                        <?php
                    } else {
                        ?>
                        <tr>
                            <td align="left" colspan="29">No Merchants found</td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

