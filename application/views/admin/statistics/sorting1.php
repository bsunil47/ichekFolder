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
        $("#txtinput").autocomplete({
            minLength: 0,
            source: function (request, response) {
                $.getJSON("<?php echo base_url(); ?>Admin/statistics/getUserEmail", {
                    term: extractLast(request.term)
                }, response);
            },
            focus: function (event, ui) {
                $("#txtinput2").val(ui.item.id);
                return false;
            },
            select: function (event, ui) {
                $("#txtinput2").val(ui.item.id);
                $("#txtinput").val(ui.item.value);
                return false;
            }
        })

    });
</script>
<input type="text" id="txtinput" size="20" />
<input type="hidden" id="txtinput2" size="20" />
