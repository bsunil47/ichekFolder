<!DOCTYPE html>
<html lang="en">
    <head>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ichek</title>
        <link type="text/css" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link type="text/css" href="<?php echo base_url(); ?>bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link type="text/css" href="<?php echo base_url(); ?>css/theme.css" rel="stylesheet">
        <link type="text/css" href="<?php echo base_url(); ?>images/icons/css/font-awesome.css" rel="stylesheet">
        <link type="text/css" href='<?php echo base_url(); ?>css/fonts.css' rel='stylesheet'>

    </head>
    <body>
        <div class="navbar navbar-fixed-top">
            <?php $this->load->view('includes/header'); ?>

        </div>
        <!-- /navbar -->
        <div class="wrapper">
            <div class="container">
                <div class="row">
                    <div class="span3">

                        <?php $this->load->view('includes/leftmenu'); ?>
                    </div>
                    <div class="span9">
                        <?php echo $content_for_layout; ?>
                    </div>
                    <!--/.span9-->
                </div>
            </div>
            <!--/.container-->
        </div>
        <!--/.wrapper-->

        <?php $this->load->view('includes/footer'); ?>

        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript">
            google.load("visualization", "1", {packages: ["corechart"]});
            google.setOnLoadCallback(drawChart);
            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Users', 'Users in Ichek'],
                    ['Customers- <?php echo $customers->count; ?>', <?php echo $customers->count; ?>],
                    ['Merchants- <?php echo $merchant->count; ?>', <?php echo $merchant->count; ?>],
                    ['Admin Users- <?php echo $users->count; ?>', <?php echo $users->count; ?>]
                ]);

                var options = {
                    pieSliceText: 'value',
                    tooltip: {text: 'value'},
                    //legend: 'none',
                    //pieSliceText: 'label',
                    //title: 'Users in Ichek',
                    //pieStartAngle: 100,
                    pieHole: 0.4,
                };

                var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
                chart.draw(data, options);
            }
        </script>

        <script src="<?php echo base_url(); ?>js/jquery-1.9.1.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>js/flot/jquery.flot.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>js/flot/jquery.flot.resize.js"></script>
        <script src="<?php echo base_url(); ?>js/flot/jquery.flot.pie.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>js/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>js/common.js" type="text/javascript"></script>

    </body>
</html>