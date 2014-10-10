<div class="body">
    <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">
        <input type="hidden" name="employee_id" value="<?php echo $employee->id; ?>" />
        <legend class="section">เพิ่ม Staff Pick</legend>
        <div class="form-group">
            <label class="control-label">ชื่อ - สกุล</label>
            <div class="controls form-group">
                <input type="text" class="form-control" readonly value="<?php echo $employee->employee_display_name; ?>" />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label">ประเภท</label>
            <div class="controls form-group">
                <div class="btn-group" data-toggle="buttons">
                    <label id="type_1" class="btn btn-<?php if($employee->employee_prefer == "fulltime"){ ?>primary<?php } else { ?>default<?php } ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input type="radio" name="pick_type" value="1" <?php if($employee->employee_prefer == "fulltime"){ ?>checked<?php } ?>> พนักงานประจำ
                    </label>
                    <label id="type_2" class="btn btn-<?php if($employee->employee_prefer == "freelance"){ ?>primary<?php } else { ?>default<?php } ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input type="radio" name="pick_type" value="2" <?php if($employee->employee_prefer == "freelance"){ ?>checked<?php } ?>> ฟรีแลนซ์
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label">เป็น Staff Pick ของวันที่</label>
            <div class="controls form-group">
                <input id="btn-enabled-date" class="form-control date-picker" type="text" name="pick_date" value="<?php echo isset($pick)?$pick->pick_date:date('Y-m-d'); ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label">Cover Photo</label>
            <div class="controls form-group">
                    <span class="btn btn-default fileinput-button">
                        <i class="fa fa-plus"></i>
                        <span id="pick-photo-file-name">เลือกไฟล์ภาพ</span>
                        <input id="pick-photo-file" type="file" name="pick_photo_file" accept="image/*" />
                    </span>
                <p class="help-block">รองรับไฟล์ .jpg และ .png</p>
            </div>
            <div class="controls form-group">
                <div>
                    <img id="pick-photo-preview" src="http://placehold.it/640x480/fff.png" border="0" style="width:50%;" />
                </div>
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
        <legend class="section">ทักษะและระดับทักษะของ Staff Pick</legend>
        <div id="skills">
            <?php if(count($skills)){ ?>
                <?php foreach($skills as $s){ ?>
                    <?php
                    $level = 0;
                    if($s['skill_level'] == "Basic") $level = 30;
                    else if($s['skill_level'] == "Advanced") $level = 60;
                    else if($s['skill_level'] == "Expert") $level = 90;
                    ?>
                    <div class="row">
                        <div class="col-lg-4">
                            <input type="text" class="form-control skill-title" name="skill_title[]" maxlength="255" placeholder="กรอกชื่อทักษะ" value="<?php echo $s['skill_title']; ?>" />
                        </div>
                        <div class="col-lg-2">
                            <div class="input-group">
                                <input type="text" class="form-control skill-level" name="skill_level[]" placeholder="กรอกตัวเลข 0 - 100" value="<?php echo $level; ?>">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-default skill-level-plus"><i class="fa fa-plus"></i></button>
                                    <button type="button" class="btn btn-default skill-level-minus"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <button type="button" class="btn btn-danger skill-delete"><i class="fa fa-times"></i> เอาออก</button>
                        </div>
                    </div>
                    <p class="fc-header-space"></p>
                <?php } ?>
            <?php } ?>
        </div>
        <button type="button" class="btn btn-info" id="btn-add-skill"><i class="fa fa-plus"></i> เพิ่มทักษะ</button>
        <div class="form-actions">
            <?php echo Form::submit('submit', 'บันทึก', array('class' => 'btn btn-success')); ?>
            <?php echo Form::button('clear', 'ล้าง', array('class' => 'btn btn-default')); ?>
        </div>
    </form>
</div>