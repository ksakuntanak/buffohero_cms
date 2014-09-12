<?php $error = Session::get_flash('error'); ?>
<?php if(strlen($error)) { ?>
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <p><?php echo $error; ?></p>
    </div>
<?php } ?>
<section class="widget">
    <div class="body">
        <form action="" method="post" class="form-horizontal">
            <input type="hidden" name="employee_id" value="<?php echo $employee->id; ?>" />
            <legend class="section">เพิ่ม Staff Pick</legend>
            <div class="form-group">
                <label class="control-label">ชื่อ - สกุล</label>
                <div class="controls form-group">
                    <input type="text" class="form-control" readonly value="<?php echo $employee->employee_display_name; ?>" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">เป็น Staff Pick ของวันที่</label>
                <div class="controls form-group">
                    <input id="btn-enabled-date" class="form-control date-picker" type="text" name="pick_date" value="<?php echo isset($pick)?$pick->pick_date:date('Y-m-d'); ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">สถานะ</label>
                <div class="controls form-group">
                    <div class="btn-group" data-toggle="buttons">
                        <label id="active_1" class="btn btn-<?php echo (!isset($pick) || isset($pick) && $pick->pick_is_active == 1)?"primary":"default"; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                            <input type="radio" name="pick_is_active" value="1" <?php if(!isset($pick) || isset($pick) && $pick->pick_is_active == 1){ ?>checked="checked" <?php } ?>> เผยแพร่
                        </label>
                        <label id="active_0" class="btn btn-<?php echo (isset($pick) && $pick->pick_is_active == 0)?"danger":"default"; ?>" data-toggle-class="btn-danger" data-toggle-passive-class="btn-default">
                            <input type="radio" name="pick_is_active" value="0" <?php if(isset($pick) && $pick->pick_is_active == 0){ ?>checked="checked" <?php } ?>> ระงับ
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <?php echo Form::submit('submit', 'บันทึก', array('class' => 'btn btn-success')); ?>
                <?php echo Form::button('clear', 'ล้าง', array('class' => 'btn btn-default')); ?>
            </div>
        </form>
    </div>
</section>