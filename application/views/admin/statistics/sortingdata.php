<div class="content">
    <div class="module">
        <div class="module-head">
            <h3>Redeemed Offers</h3> (From Date:-<?php echo $results['frmdate']; ?> - To Date:- <?php echo $results['tdate']; ?>) (Sort Type:- <?php echo $sortname; ?>)</div>
        <div class="module-body table">
            <form>
                <input type="hidden" id="sorttype" name="sorttype" value="<?php echo $results['sorttype']; ?>">
                <input type="hidden" id="fromdate" name="fromdate" value="<?php echo $results['frmdate']; ?>">
                <input type="hidden" id="todate" name="todate" value="<?php echo $results['tdate']; ?>">
                <input type="hidden" id="user_id" name="user_id" value="<?php echo $results['sort_id']; ?>">
            </form>
            <table cellpadding="0" cellspacing="0" border="0" class="datatable-30 table table-bordered table-striped display" width="100%">
                <thead>
                    <tr>
                        <th align="left">S.No</th>
                        <th align="left">Offer</th>
                        <th align="left">Merchant Name</th>
                        <th align="left">Category</th>
                        <th align="left">Redeem Count</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>

        </div>
    </div>
</div>	<?php
//print_r($_POST)      ?>