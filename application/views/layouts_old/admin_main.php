<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>iCheck</title>
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/style1.css" />
        <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
        <script src="<?php echo base_url(); ?>js/main.js"></script>
    </head>
    <body>
        <!--header start -->
        <?php $this->load->view('includes/header'); ?>
        <!--header end -->
        <!--left menu -->
        <?php $this->load->view('includes/leftmenu'); ?>
        <!--left menu ends -->
        <!-- middle part -->			
        <?php echo $content_for_layout; ?>
        <!-- middle part ends -->
        <?php $this->load->view('includes/footer'); ?>
        </div> <!-- Main div starts -->

    </body>
</html>