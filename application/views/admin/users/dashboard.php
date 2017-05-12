<div class="content">
    <div class="btn-controls">
        <div class="btn-box-row row-fluid">
            <div class="span8">
                <div class="row-fluid">
                    <div class="span12">
                        <a href="<?php echo base_url(); ?>Admin/users/userlist"  class="btn-box small span4"><i class=" icon-group"></i><b><?php echo $users->count; ?></b>Users</a>
                        <a href="<?php echo base_url(); ?>Admin/users/merchants" class="btn-box small span4"><i class="icon-group"></i><b><?php echo $merchant->count; ?></b>Merchants</a>
                        <a href="<?php echo base_url(); ?>Admin/users/customers" class="btn-box small span4"><i class="icon-group"></i><b><?php echo $customers->count; ?></b>Customers</a>

                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <a href="<?php echo base_url(); ?>Admin/finance"  class="btn-box small span4"><i class="icon-download"></i><b><?php
                                if (!empty($cahoutsum->cashout)) {
                                    echo $cahoutsum->cashout;
                                } else {
                                    echo 0;
                                }
                                ?></b>Cashout</a>
                        <a href="<?php echo base_url(); ?>Admin/finance/topuplist" class="btn-box small span4"><i class="icon-upload"></i><b><?php echo $topupsum->topup; ?></b>Topup</a>
                        <a href="<?php echo base_url(); ?>Admin/finance" class="btn-box small span4"><i class="icon-money"></i><b><?php echo $customers->count; ?></b>Profit</a>

                    </div>
                </div>
            </div>
            <ul class="widget widget-usage unstyled span4" style="min-height: 278px">
                <?php foreach ($models as $key => $value) {
                    ?>
                    <li>
                        <p>
                            <strong><?php echo $value->model; ?></strong> <span class="pull-right small muted"><?php echo $value->cnt; ?></span>
                        </p>
                        <div class="progress tight">
                            <div class="bar" style="width: <?php echo $value->cnnt; ?>%;">
                            </div>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <?php
    $val_data = "[['Date', 'Merchants', 'Customers'],";
    foreach ($gr as $key => $value) {
        (!empty($value['merchant'])) ? $merchant_v = $value['merchant'] : $merchant_v = 0;
        (!empty($value['customer'])) ? $customer_v = $value['customer'] : $customer_v = 0;
//jS \of F Y date('jS \of F Y', $key)
        $val_data = $val_data . "['" . date('j M y', strtotime($key)) . "'," . $merchant_v . "," . $customer_v . "],";
    }
    trim($val_data, ",");
    ?>
    <?php
    $val_datanew = "[['Date', 'Cashout', 'Topup'],";
    foreach ($dates as $key => $value) {

        (!empty($cashout[$value])) ? $cashout_v = $cashout[$value] : $cashout_v = 0;
        (!empty($topup[$value])) ? $topup_v = $topup[$value] : $topup_v = 0;

        $val_datanew = $val_datanew . "['" . date('j M y', strtotime($value)) . "'," . $cashout_v . "," . $topup_v . "],";
    }
    trim($val_datanew, ",");
    ?>
    <script type="text/javascript">
        var d_r = <?php echo trim($val_data, ",") . ']'; ?>;
        var d_rnew = <?php echo trim($val_datanew, ",") . ']'; ?>;
    </script>
    <div class="btn-controls">
        <div class="btn-box-row row-fluid">
            <div class="module span6">
                <div class="module-head"><h3> Users</h3></div>

                <div id="donutchart" class="graph" > </div>

            </div>
            <!--/.module-->
            <!--    <br />-->

            <div class="module span6">
                <div class="module-head"><h3> Users Login Count</h3>  </div>

                <div id="curve_chart" ></div>

            </div>
        </div>
    </div>
    <!--/.module-->
    <!--    <br />-->
    <div class="btn-controls">
        <div class="btn-box-row row-fluid">
            <div class="module span12">
                <div class="module-head"><h3> Cash In & Out</h3>  </div>

                <div id="curve_chart1"></div>

            </div>
        </div>
    </div>
</div>
<!--/.module-->
<!--    <br />-->

