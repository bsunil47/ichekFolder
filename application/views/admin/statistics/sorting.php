<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />

<!-- Load jQuery JS -->
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<!-- Load jQuery UI Main JS  -->
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

<!-- Load SCRIPT.JS which will create datepicker for input field  -->
<!--    <script src="script.js"></script>-->
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
                if (v == 'all')
                {//alert(v);
                    document.getElementById('sorttype').value = v;
                    document.getElementById('sort_id').value = v;
                    document.getElementById('sort_group').style.display = 'none';
                } else {
                    document.getElementById('sorttype').value = v;

                    document.getElementById('sort_group').style.display = 'block';
                    if (v == '4' || v == 5 || v == 2)
                    {
                        $('#sort_label').html(sort_array[v]);
                    } else {
                        document.getElementById('sort_group').style.display = 'none';
                    }
                }

            }
</script>
<!-- Jquery Packages -->
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
<script src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
<!-- Jquery Package End -->
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
</script>
<div class="content">
    <div class="module">
        <div class="module-head">
            <h3>Sort Reedem Statistics</h3></div>
        <div class="module-body">
            <form id="addfaq" name="sorting" class="form-horizontal row-fluid" action="<?php echo base_url() . 'Admin/statistics/sortingdata'; ?>" method="post">

                <div class="control-group">
                    <label class="control-label" for="fromdate">from Date:</label>
                    <div class="controls">
                        <?php echo form_input('fromdate', $this->input->post('from'), 'id="from", class="span8" placeholder="Select Date" autocomplete="off"'); ?>
                        <?php //echo form_error('question'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="todate">to Date:</label>
                    <div class="controls">
                        <?php echo form_input('todate', $this->input->post('to'), 'id="to", class="span8" placeholder="Select Date" autocomplete="off"'); ?>
                        <?php //echo form_error('question'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="select">Select from sort type:</label>
                    <div class="controls">
                        <select name="myselect" onchange="gettype(this.value)">
                            <option value="" selected="">-Select-</option>
                            <option value="all"  <?php echo set_select('myselect', 'all'); ?> >All</option>
                            <option value="4" <?php echo set_select('myselect', 'merchant'); ?> >merchant</option>
                            <option value="5" <?php echo set_select('myselect', 'user'); ?> >user</option>
                            <option value="2" <?php echo set_select('myselect', 'catageory'); ?> >catageory</option>
                        </select>
                        <input type="hidden" name="sorttype" id="sorttype">
                    </div>
                </div>
                <!--            <div class="control-group" >
                                <label class="control-label" for="user">Enter Value:</label>
                                <div class="controls">
                                    <input type="text" id="sortname" size="20" />
                                    <input type="hidden" name="sort_id" id="sort_id" size="20" />

                               </div>
                                </div>-->
                <div class="control-group" id="sort_group" style="display:none;">
                    <label class="control-label" for="user" id="sort_label">Select Merchant:</label>
                    <div class="controls">
                        <input type="text" id="sortname" size="20" />
                        <input type="hidden" name="sort_id" id="sort_id" size="20" />

                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
                        <?php echo form_submit('submit', 'Search', 'id="submit"', 'name="submit"', 'class="btn-primary"'); ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

