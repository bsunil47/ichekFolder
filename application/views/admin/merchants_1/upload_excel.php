<div class="content">
<div class="module">
<div class="module-head"><h3>Add Merchants New</h3></div>
<div class="module-body">
<?php if(!empty($result)){echo $result; } ?>
<?php 
$attributes = array('class' => "form-horizontal row-fluid",'id' => "merchanstexcel_form1");
echo form_open_multipart(base_url() . 'Admin/merchants_1/upload_excel',$attributes);?>

<div class="control-group">
<label class="control-label" for="basicinput">Upload Excel:</label>
<div class="controls">
<?php echo "<input type='file' name='excel_file'  id='excel_file' />"; ?>
<?php echo form_error('excel_file'); ?>
</div>
</div>

<div class="control-group">
<div class="controls">
<?php echo form_submit('submit', 'Upload', 'id="submit"', 'name="submit"'); ?>
</div>
</div>
<?php echo form_close(); ?>
</div>
</div>
</div>	