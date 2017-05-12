<link type="text/css" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link type="text/css" href="<?php echo base_url(); ?>bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
<link type="text/css" href="<?php echo base_url(); ?>css/theme.css" rel="stylesheet">
<link type="text/css" href="<?php echo base_url(); ?>images/icons/css/font-awesome.css" rel="stylesheet">
<link type="text/css" href='<?php echo base_url(); ?>css/fonts.css' rel='stylesheet'>

<script>var base_url = "<?php echo base_url(); ?>";</script>

<!-- /navbar -->
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="span3">


            </div>
            <div class="span9">

                <div class="content">
                    <div class="module">
                        <div class="module-head">
                            <h3>Merchant Signup</h3></div>
                        <div class="module-body">

                            <form method="post" name="addendmerchant" id="addendmerchant" class="form-horizontal row-fluid">

                                <div class="control-group">
                                    <label class="control-label" for="firstname">First Name:</label>
                                    <div class="controls">
                                        <input name="firstname" type="text"/>
                                        <?php echo form_error('firstname'); ?>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="lastname">Last Name:</label>
                                    <div class="controls">
                                        <input name="lastname" type="text"/>
                                        <?php echo form_error('lastname'); ?>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="email">Email:</label>
                                    <div class="controls">
                                        <input name="email" type="text"/>
                                        <?php echo form_error('email'); ?>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="email">Password:</label>
                                    <div class="controls">
                                        <input name="password" type="password"/>
                                        <?php echo form_error('password'); ?>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="email">Location:</label>
                                    <div class="controls">
                                        <input name="location" type="text"/>
                                        <?php echo form_error('location'); ?>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <div class="controls">
                                        <input name="submit" type="submit"/>
                                    </div>
                                </div>

                            </form>
                            <div style="font:bold; padding-bottom: 10px;padding-left: 10px; color:<?php if (isset($error)) { ?>red<?php } else { ?>green<?php } ?>"    ><?php
                                if (isset($error)) {
                                    echo $error;
                                } else {
                                    echo $success;
                                }
                                ?></div>


                            <!--</div>-->

                            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
                            <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.validate.min.js"></script>
                            <script type="text/javascript" src="<?php echo base_url(); ?>js/additional-methods.min.js"></script>
                            <script src="<?php echo base_url(); ?>js/jquery-migrate-1.2.1.min.js"></script>
                            <script src="<?php echo base_url(); ?>js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
                            <script type="text/javascript" src="https://www.google.com/jsapi"></script>
                            <script src="<?php echo base_url(); ?>js/form_validation.js" type="text/javascript"></script>