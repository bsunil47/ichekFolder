<div class="content">
    <div class="module">
        <div class="module-head">
            <h3>Add FAQ'S</h3></div>
        <div class="module-body">
            <form id="addfaq" name="addfaq" class="form-horizontal row-fluid" action="<?php echo base_url() . 'Admin/general/faqadd'; ?>" method="post">
                <div class="control-group">
                    <label class="control-label" for="basicinput">FAQ for:</label>
                    <div class="controls">
                        <!--<input type="text" name="column1" value="<?php if (!empty($contact->column1)) echo $contact->column1; ?>" class="span8" />-->
                        <select name="type" class="span8">
                            <option value="1" >Customer</option>
                            <option value="0" >Business</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="question">Question:</label>
                    <div class="controls">
                        <?php echo form_input('question', $this->input->post('question'), 'id="question", class="span8" placeholder="Enter Question" autocomplete="off"'); ?>
                        <?php echo form_error('question'); ?>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="answer">Answer</label>
                    <div class="controls">
                        <?php echo form_textarea('answer', $this->input->post('answer'), 'id="answer", class="span8" placeholder="Enter Answer" autocomplete="off"'); ?>
                        <?php echo form_error('answer'); ?>
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
                        <?php echo form_submit('submit', 'Add', 'id="submit"', 'name="submit"', 'class="btn-primary"'); ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>