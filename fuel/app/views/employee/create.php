<?php $error = Session::get_flash('error'); ?>
<?php if(strlen($error)) { ?>
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <p><?php echo $error; ?></p>
    </div>
<?php } ?>
<section class="widget">
    <?php echo render('employee/_form'); ?>
</section>