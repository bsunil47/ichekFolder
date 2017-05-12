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
        <link type="text/css" href='<?php echo base_url(); ?>css/emoji.css' rel='stylesheet'>
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
        <style>
            .cmn-toggle {
                position: absolute;
                margin-left: -9999px;
                visibility: hidden;
            }
            .cmn-toggle + label {
                display: block;
                position: relative;
                cursor: pointer;
                outline: none;
                user-select: none;
            }
            input.cmn-toggle-round + label {
                padding: 2px;
                width: 60px;
                height: 30px;
                background-color: #dddddd;
                border-radius: 30px;
            }
            input.cmn-toggle-round + label:before,
            input.cmn-toggle-round + label:after {
                display: block;
                position: absolute;
                top: 1px;
                left: 1px;
                bottom: 1px;
                content: "";
            }
            input.cmn-toggle-round + label:before {
                right: 1px;
                background-color: #f1f1f1;
                border-radius: 30px;
                transition: background 0.4s;
            }
            input.cmn-toggle-round + label:after {
                width: 32px;
                background-color: #fff;
                border-radius: 100%;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
                transition: margin 0.4s;
            }
            input.cmn-toggle-round:checked + label:before {
                background-color: #8ce196;
            }
            input.cmn-toggle-round:checked + label:after {
                margin-left: 30px;
            }
        </style>
        <script>
            var userid_log = null;
        </script>
        <style>
            .black_overlay{
                display: none;
                position: absolute;
                top: 0%;
                left: 0%;
                width: 100%;
                height: 100%;
                background-color: black;
                z-index:1001;
                -moz-opacity: 0.8;
                opacity:.80;
                filter: alpha(opacity=80);
            }
            .white_content {
                display: none;
                /*position: aboslute;*/
                position: fixed;
                top: 25%;
                left: 25%;
                width: 50%;
                height: 50%;
                background-color: white;
                z-index:1002;
                overflow: auto;
            }
        </style>
    </head>
    <body>
        <script>var base_url = "<?php echo base_url(); ?>";</script>
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
        <div id="light" class="white_content">
            <div class="content" style="height:100%;">

                <div class="module" style="height: 98%; margin-bottom: 0px;">
                    <div class="module-head">
                        <h3><span class="pop-title">Forms</span> <a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'" s><button class="close"  type="button" style="font-size: 35px">×</button></a></h3>
                    </div>
                    <div class="module-body" >

                        <div class="profile-head media" style="padding-left: 50px; padding-top: 50px;">
                            <a class="media-avatar pull-left" href="#">
                                <img class="popup-image" src="images/user.png">
                            </a>
                            <div class="media-body" style="padding-left: 50px;">
                                <h4 class="popup-username">
                                    John Donga
                                </h4>
                                <p>
                                    <small class="muted popup-email"></small>
                                </p>
                                <p>
                                    <small class="muted popup-mobile"></small>
                                </p>
                                <p>
                                    <small class="muted popup-merchant"></small>
                                </p>

                            </div>
                        </div>


                    </div>
                </div>



            </div>
        </div>
        <div id="fade" class="black_overlay"></div>
        <?php $this->load->view('includes/footer'); ?>

<!--        <script type="text/javascript" src="https://www.google.com/jsapi"></script>-->


        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.validate.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/additional-methods.min.js"></script>
        <script src="<?php echo base_url(); ?>js/jquery-migrate-1.2.1.min.js"></script>
        <script src="<?php echo base_url(); ?>js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<!--        <script src="<?php echo base_url(); ?>js/flot/jquery.flot.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>js/flot/jquery.flot.resize.js"></script>
        <script src="<?php echo base_url(); ?>js/flot/jquery.flot.pie.js" type="text/javascript"></script>-->
        <script src="<?php echo base_url(); ?>js/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>js/common.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>js/form_validation.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>js/tinymce/tinymce.min.js" type="text/javascript"></script>
        <?php if ($this->router->fetch_method() == 'dashboard') { ?>
            <script type="text/javascript">

                    google.load("visualization", "1", {packages: ["corechart"]});
                    google.setOnLoadCallback(drawChart);
                    function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                            ['Users', 'Users in Ichek'],
                            ['Customers', <?php echo $customers->count; ?>],
                            ['Merchants', <?php echo $merchant->count; ?>],
                            ['Admin Users', <?php echo $users->count; ?>]
                    ]);
                            var options = {
                            pieSliceText:'value',
                                    tooltip:{text:'value'},
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
            <script type="text/javascript"
                    src="https://www.google.com/jsapi?autoload={
                    'modules':[{
                    'name':'visualization',
                    'version':'1',
                    'packages':['corechart']
                    }]
            }"></script>

            <script type="text/javascript">
                    google.setOnLoadCallback(drawChart);
                    function drawChart() {
                    var data = google.visualization.arrayToDataTable(
                            d_r
                            );
                            var options = {
                            title: 'Users login stats',
                                    'height':300,
                                    curveType: 'function',
                                    //                                        legend: { position: 'bottom' },
                                    hAxis: {
                                    direction: 1,
                                            slantedText:true,
                                            slantedTextAngle:55 // here you can even use 180
                                    }
                            };
                            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
                            chart.draw(data, options);
                            var data1 = google.visualization.arrayToDataTable(
                                    d_rnew
                                    );
                            var options1 = {
                            title: 'Cash In & Out',
                                    'height':300,
                                    curveType: 'function',
                                    //                                        legend: { position: 'bottom' },
                                    hAxis: {
                                    direction: - 1,
                                            slantedText:true,
                                            slantedTextAngle:55 // here you can even use 180
                                    }
                            };
                            var chart1 = new google.visualization.LineChart(document.getElementById('curve_chart1'));
                            chart1.draw(data1, options1);
                    }

            </script>
        <?php } ?>
        <script type="text/javascript">
            var man_status;
                    function followers(v)
                    {
                    man_status = v;
                    }
            function update_follow_status(val, id_div){
            //alert(id_div);
            $.ajax({
            url: '<?php echo base_url(); ?>Admin/merchants/updatefollwers',
                    type:'POST',
                    data: {
                    user_id:val, followers_management:man_status},
                    success: function(data){
                    console.log(id_div);
                            if (man_status == 0){
                    $('#sc' + id_div).text('Low');
                    }
                    if (man_status == 1){
                    $('#sc' + id_div).text('Medium');
                    }
                    if (man_status == 2){
                    $('#sc' + id_div).text('High');
                    }
                    return true;
                    }
            });
            }
            tinymce.init({
            selector: "textarea",
                    theme: "modern",
                    width: 500,
                    plugins: [
                            "textcolor advlist autolink link lists charmap preview hr anchor pagebreak spellchecker",
                            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking",
                            "save table contextmenu directionality emoticons template paste"
                    ],
                    content_css: "css/content.css",
                    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview fullpage | forecolor backcolor emoticons",
            });</script>
        <script type="text/javascript">
                    $(document).ready(
                    /* This is the function that will get executed after the DOM is fully loaded */
                            function () {
                            $("#from").datepicker({
                            changeMonth: true, //this option for allowing user to select month
                                    changeYear: true //this option for allowing user to select from year range
                            });
                                    $("#to").datepicker({
                            changeMonth: true, //this option for allowing user to select month
                                    changeYear: true //this option for allowing user to select from year range
                            });
                            }

                    );
//auto complete script
                            function gettype(v)
                            {
                            var sort_array = {
                            4: 'Select Merchant',
                                    5: 'Select Customer',
                                    2: 'Select Category'
                            }
                            document.getElementById('sorttype').value = v;
                                    document.getElementById('sort_group').style.display = 'block';
                                    if (v == '4' || v == 5 || v == 2)
                            {
                            $('#sort_label').html(sort_array[v]);
                            } else {
                            document.getElementById('sort_group').style.display = 'none';
                            }

                            }
        </script>
        <style>
            #txtinput{width:400px;height: 30px;border-radius:8px;border:1px solid #999;}
            .ui-autocomplete {
                max-height: 100px;
                overflow-y: auto;
                /* prevent horizontal scrollbar */
                overflow-x: hidden;
            }
        </style>
        <script type="text/javascript">
                    $(document).ready(function () {
                    function split(val) {
                    return val.split(/,\s*/);
                    }
                    function extractLast(term) {
                    return split(term).pop();
                    }
                    var search_val;
                            //var stype=$("#sorttype").val();
                            $("#sortname").autocomplete({
                    minLength: 0,
                            source: function (request, response) {
                            $.post("<?php echo base_url(); ?>Admin/statistics/getFilterData", {
                            term: extractLast(request.term),
                                    type: $("#sorttype").val()
                            }, response, 'json');
                            },
                            focus: function (event, ui) {
                            $("#sort_id").val(ui.item.id);
                                    return false;
                            },
                            select: function (event, ui) {
                            $("#sort_id").val(ui.item.id);
                                    $("#sortname").val(ui.item.value);
                                    return false;
                            }
                    })
                    });
                            function blast_select(val, id, row){
                            if (val == 0){
                            $('#amount' + id + row).val(0);
                            }
                            }
                    function update_blast(id, row){
//                    alert('f' + row + id);
//                            var s = $('input:radio[name = f' + id + row + ']:checked').val();
//                            alert(s);
//                            alert($('#amount' + id + row).val());
                    $.ajax({
                    url: '<?php echo base_url(); ?>Admin/merchants/updateblast',
                            type:'POST',
                            data: {
                            user_id: id,
                                    blast_status: $('input:radio[name = f' + id + row + ']:checked').val(),
                                    blast_amount: $('#amount' + id + row).val()
                            },
                            success: function(data){
                            console.log(data);
                                    return true;
                            }
                    });
                    }
        </script>
        <script>
                    $(document).ready(function () {/*
                        $('.popup_display').on('click',function(){
                            $('.popup-image').attr('src',$(this).attr('data-image_url'));
                            $('.black_overlay').show();
                            $('.white_content').show();
                            $('.pop-title').html($(this).attr('data-title'));
                            $('.popup-username').html($(this).attr('data-name'));
                            $('.popup-mobile').html('<b>Mobile: <b>'+$(this).attr('data-mobile'));
                            $('.popup-email').html('<b>Email: <b>'+$(this).attr('data-email'));


                            if($(this).attr('data-usertype') == 4){
                            $('.popup-merchant').html('<b>Display Name: <b>'+$(this).attr('data-business_name'));
                            }
                            else
                        {
                            $('.popup-merchant').html('');
                        }

                            //console.log();
                        });*/
                    $('.widget-menu>li>a').click(function(){
                    if ($(this).attr('data-toggle') == 'collapse'){
                    $('.collapse').removeClass('in');
                            $(".collapse").css("height", "0");
                            $(this).removeClass('collapsed');
                            $('.icon-chevron-down').css('display', 'block');
                            $('.icon-chevron-up').css('display', 'none');
                            $(this).children('.icon-chevron-up').css('display', 'block');
                            $(this).children('.icon-chevron-down').css('display', 'none');
                    }
                    })
                    });

            function popupDiv(e){
                $('.black_overlay').height($(document).height());
                $('.popup-image').attr('src',$(e).attr('data-image_url'));
                $('.black_overlay').show();
                $('.white_content').show();
                $('.pop-title').html($(e).attr('data-title'));
                $('.popup-username').html($(e).attr('data-name'));
                $('.popup-mobile').html('<b>Mobile: <b>'+$(e).attr('data-mobile'));
                $('.popup-email').html('<b>Email: <b>'+$(e).attr('data-email'));
                var winH = $(window).height();
                var winW = $(window).width();
                $('.white_content').css('top',  winH/2-$(id).height()/2);

                if($(e).attr('data-usertype') == 4){
                    $('.popup-merchant').html('<b>Display Name: <b>'+$(e).attr('data-business_name'));
                }
                else
                {
                    $('.popup-merchant').html('');
                }
            }
            function statusMerchant(e){
                //console.log($(e).attr('data-url'));
                $.get($(e).attr('data-url'), function (data) {
                    //console.log(data);
                });
            }

        </script>
    </body>
</html>