<header>
    <h4><i class="fa fa-bars"></i> ข้อมูลหัวข้อช่วยเหลือ</h4>
</header>
<div class="body">
    <?php echo Form::open(array("id" => "form-help", "class" => "form-horizontal", "enctype" => "multipart/form-data")); ?>
    <?php echo Form::fieldset_open(); ?>

        <input type="hidden" name="action" value="edit_help" />

        <div class="form-group">
            <?php echo Form::label('หมวดหมู่ <span class="required">*</span>', 'cat_id', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <select id="cat_id" data-placeholder="ระบุหมวดหมู่" class="col-xs-12 col-sm-12 chzn-select" name="cat_id">
                    <option value=""></option>
                    <?php foreach($cats as $id => $title){ ?>
                        <option value="<?php echo $id; ?>" <?php if(isset($help)&&$id==$help->cat_id) { ?>selected="selected"<?php } ?>><?php echo $title; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <?php echo Form::label('หัวข้อช่วยเหลือ (TH) <span class="required">*</span>', 'help_title_th', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('help_title_th', Input::post('help_title_th', isset($help) ? $help->help_title_th : ''), array('class' => 'form-control', 'placeholder' => 'ระบุหัวข้อช่วยเหลือเป็นภาษาไทย')); ?>
                <p class="help-block">ไม่เกิน 255 ตัวอักษร</p>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('หัวข้อช่วยเหลือ (EN) <span class="required">*</span>', 'help_title_en', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('help_title_en', Input::post('help_title_en', isset($help) ? $help->help_title_en : ''), array('class' => 'form-control', 'placeholder' => 'ระบุหัวข้อช่วยเหลือเป็นภาษาอังกฤษ')); ?>
                <p class="help-block">ไม่เกิน 255 ตัวอักษร</p>
            </div>
        </div>

        <div class="form-group">
            <?php echo Form::label('เนื้อหา (TH)', 'help_detail_th', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::textarea('help_detail_th', Input::post('help_detail_th', isset($help) ? $help->help_detail_th : ''), array('class' => 'form-control htmltextarea', 'rows' => 20, 'placeholder' => 'ระบุเนื้อหาเป็นภาษาไทย')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('เนื้อหา (EN)', 'help_detail_en', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::textarea('help_detail_en', Input::post('help_detail_en', isset($help) ? $help->help_detail_en : ''), array('class' => 'form-control htmltextarea', 'rows' => 20, 'placeholder' => 'ระบุเนื้อหาเป็นภาษาอังกฤษ')); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo Form::label('สถานะ', 'help_is_active', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <div class="btn-group" data-toggle="buttons">
                    <label id="active_1" class="btn btn-<?php echo (isset($help)&&$help->help_is_active==1)?"primary":"default"; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input type="radio" name="help_is_active" value="1" <?php if(isset($help) && $help->help_is_active == 1){ ?>checked="checked" <?php } ?>> เผยแพร่
                    </label>
                    <label id="active_0" class="btn btn-<?php echo (!isset($help) || isset($help)&&$help->help_is_active == 0)?"danger":"default"; ?>" data-toggle-class="btn-danger" data-toggle-passive-class="btn-default">
                        <input type="radio" name="help_is_active" value="0" <?php if(!isset($help) || isset($help)&&$help->help_is_active==0){ ?>checked="checked" <?php } ?>> ระงับ
                    </label>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a class="btn btn-success" href="javascript:void(0);" onclick="$('#form-help').submit();">Save</a>
            <a class="btn btn-default" href="<?php echo Uri::create('help'); ?>">Cancel</a>
        </div>

    <?php echo Form::fieldset_close(); ?></fieldset>
    <?php echo Form::close(); ?>
</div>