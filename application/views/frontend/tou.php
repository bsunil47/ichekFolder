<div class="page-header">
    <h1 style="font-family: 'Exo 2'">iChek</small></h1>
</div>

<!-- Bootstrap FAQ - START -->
<div class="container">


    <div class="panel-group" >
        <?php foreach ($tou as $key => $row) { ?>
            <div class="panel panel-default" style="font-family: 'Exo 2'">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle"><?php echo $row->column1; ?></a>
                    </h4>
                </div>
                <div class="panel-collapse collapse in">
                    <div class="panel-body" style="font-family: 'Exo 2'">
                        <?php echo $row->column2; ?>
                    </div>
                </div>
            </div><?php } ?>
    </div>
</div>
