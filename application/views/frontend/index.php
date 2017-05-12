<div class="module module-login span4 offset4">
<?php echo form_open(base_url()); ?>
<div class="module-head"><h3>Sign in to iChek Merchant</h3></div>
<div class="module-body">
 <div class="control-group">
 <div class="controls row-fluid">
   <?php echo form_input('email', $this->input->post('email'), 'id="email", class="span12" placeholder="Enter Email Address" autocomplete="off"'); ?>
   <?php echo form_error('email'); ?>
  </div>
  </div>
  
 <div class="control-group">
 <div class="controls row-fluid">
   <?php echo form_password('password', '', 'id="password", class="span12" placeholder="Please Enter password" autocomplete="off"'); ?>
   <?php echo form_error('password'); ?>
  </div>
  </div>
  </div>
  
<div class="module-foot">
<div class="control-group">
<div class="controls clearfix">
   <input type="submit" name="submit" id="submit" value="Login" class="btn btn-primary pull-right"  />
    <label class="checkbox"><input type="checkbox"> Remember me</label>
</div>
</div>
</div>
 <?php echo form_close(); ?>

</div>