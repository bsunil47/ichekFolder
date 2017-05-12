<!DOCTYPE html>
<html lang="en">
    <head>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ichek</title>
        <?php //echo base_url(); exit; ?>
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

        <script src="<?php echo base_url(); ?>js/jquery-1.9.1.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>js/flot/jquery.flot.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>js/flot/jquery.flot.resize.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>js/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>js/common.js" type="text/javascript"></script>

    </body>
</html>