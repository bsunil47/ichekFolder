<div class="content">
    <div class="module">
        <div class="module-head">

            <h3>FeedBack List</h3></div>
        <div class="module-body table">

            <table cellpadding="0" cellspacing="0" border="0" class=" table table-bordered table-striped display" width="100%">

                <thead>
                    <tr>
                        <th align="left">S.No</th>
                        <th align="left">email</th>
                        <th align="left">name</th>
                        <th align="left">Feedback</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //if(!empty($customers)) {
                    if (count($feedback) != 0) {
                        //foreach($customers as $row)
                        for ($i = 0; $i < count($feedback); $i++) {
                            ?>
                            <tr>

                                <td align="left"><?php
                                    $j = $i + 1;
                                    echo $j;
                                    ?></td>
                                <td align="left"><?php echo $feedback[$i]->email; ?></td>
                                <td align="left"><?php echo $feedback[$i]->firstname; ?></td>
                                <td align="left"><?php
                                    $ans = substr($feedback[$i]->column2, 0, 15);
                                    echo $ans . "..."; //echo $feedback[$i]->column2;
                                    ?></td>

                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>

                            <td align="left" colspan="5">No Feedback Found</td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>
    <!--/.module-->
</div>