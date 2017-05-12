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
                        <?php //echo form_error('question');  ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="todate">to Date:</label>
                    <div class="controls">
                        <?php echo form_input('todate', $this->input->post('to'), 'id="to", class="span8" placeholder="Select Date" autocomplete="off"'); ?>
                        <?php //echo form_error('question');  ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="select">Select from sort type:</label>
                    <div class="controls">
                        <select name="myselect" onchange="gettype(this.value)">
                            <option >All</option>
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
                        <input type="hidden" name="sort_id" id="merchant_id" size="20" />

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

