<div class="body">
    <?php echo Form::open(array("action"=>"","class"=>"form-horizontal","method"=>"post","enctype" => "multipart/form-data")); ?>
    <?php echo Form::hidden('user_id',Input::post('user_id',isset($employee)?$employee->user_id:0)); ?>
    <?php echo Form::fieldset_open(); ?>
        <legend class="section">ข้อมูลบัญชีผู้ใช้งาน</legend>
        <div class="form-group">
            <?php echo Form::label('Username <span class="required">*</span>','username',array('class'=>'control-label')); ?>
            <div class="controls form-group">
                <input type="text" name="username" class="form-control" placeholder="ระบุ Username" maxlength="255" <?php if(isset($user)){ ?>readonly<?php } ?> value="<?php echo isset($user)?$user->username:''; ?>" />
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('Password'.($menu=="create"?'<span class="required">*</span>':''),'password',array('class'=>'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('password', Input::post('password', ''), array('class' => 'form-control', 'placeholder' => 'ระบุ Password', 'type' => 'password')); ?>
                <?php if($menu == "edit") { ?><span class="help-block">ถ้าต้องการเปลี่ยน Password ให้กรอกช่องนี้</span><?php } ?>
                <span class="help-block">ความยาว 8 - 20 ตัวอักษร</span>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('Re-type Password'.($menu=="create"?' <span class="required">*</span>':''), 'password_re', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('password_re', Input::post('password_re', ''), array('class' => 'form-control', 'placeholder' => 'ระบุ Password อีกครั้ง', 'type' => 'password')); ?>
                <span class="help-block">กรอก Password เดียวกันกับช่องข้างบน</span>
            </div>
        </div>
        <legend class="section">ข้อมูลส่วนตัว</legend>
        <div class="form-group">
            <?php echo Form::label('ชื่อที่จะแสดงในโปรไฟล์ <span class="required">*</span>', 'employee_display_name', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('employee_display_name', Input::post('employee_display_name', isset($employee) ? $employee->employee_display_name:''), array('class' => 'form-control', 'placeholder' => 'ระบุชื่อโปรไฟล์')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('ตำแหน่งงาน<br/>ที่จะแสดงในโปรไฟล์', 'employee_display_position', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('employee_display_position', Input::post('employee_display_position', isset($employee) ? $employee->employee_display_position:''), array('class' => 'form-control', 'placeholder' => 'ระบุตำแหน่งงาน')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('ชื่อ <span class="required">*</span>', 'employee_firstname', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('employee_firstname', Input::post('employee_firstname', isset($employee) ? $employee->employee_firstname:''), array('class' => 'form-control', 'placeholder' => 'ระบุชื่อ')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('นามสกุล <span class="required">*</span>', 'employee_lastname', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('employee_lastname', Input::post('employee_lastname', isset($employee) ? $employee->employee_lastname:''), array('class' => 'form-control', 'placeholder' => 'ระบุนามสกุล')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('ชื่อเล่น', 'employee_nickname', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('employee_nickname', Input::post('employee_nickname', isset($employee) ? $employee->employee_nickname:''), array('class' => 'form-control', 'placeholder' => 'ระบุชื่อเล่น')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('เพศ <span class="required">*</span>', 'employee_gender', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <div class="btn-group" data-toggle="buttons">
                    <label id="gender_m" class="btn btn-<?php echo (isset($employee)&&$employee->employee_gender=="m")?"primary":"default"; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input type="radio" name="employee_gender" value="m" <?php if(isset($employee) && $employee->employee_gender == "m"){ ?>checked="checked" <?php } ?>> ชาย
                    </label>
                    <label id="gender_f" class="btn btn-<?php echo (isset($employee)&&$employee->employee_gender=="f")?"primary":"default"; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input type="radio" name="employee_gender" value="f" <?php if(isset($employee) && $employee->employee_gender == "f"){ ?>checked="checked" <?php } ?>> หญิง
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('วันเดือนปีเกิด <span class="required">*</span>', 'employee_bdate', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('employee_bdate', Input::post('employee_bdate', isset($employee)?$employee->employee_bdate:''), array('class' => 'date-picker form-control parsley-validated', 'placeholder' => 'ระบุวันเดือนปีเกิด')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('น้ำหนัก (kg)', 'employee_weight', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('employee_weight', Input::post('employee_weight', isset($employee) ? $employee->employee_weight : ''), array('type' => 'number', 'class' => 'form-control', 'placeholder' => 'ระบุน้ำหนัก')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('ส่วนสูง (cm)', 'employee_height', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('employee_height', Input::post('employee_height', isset($employee) ? $employee->employee_height : ''), array('type' => 'number', 'class' => 'form-control', 'placeholder' => 'ระบุส่วนสูง')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('รูปโปรไฟล์ <span class="required">*</span>','employee_photo_file', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                    <span class="btn btn-default fileinput-button">
                        <i class="fa fa-plus"></i>
                        <span>เลือกไฟล์รูปภาพ</span>
                        <input type="file" name="employee_photo_file">
                    </span>
                <span class="help-block">เป็นไฟล์ภาพ .png ขนาด 360 x 360 pixel</span>
            </div>
        </div>
        <?php if(isset($employee) && strlen($employee->employee_photo)) { ?>
            <div class="form-group">
                <?php echo Form::label('ไฟล์ภาพที่มีอยู่','employee_photo_file', array('class' => 'control-label')); ?>
                <div class="controls form-group">
                    <img src="//buffohero.com/uploads/profile_photo/employee/<?php echo $employee->employee_photo; ?>" border="0" style="width:360px;" />
                </div>
            </div>
        <?php } ?>
        <legend class="section">ข้อมูลสำหรับติดต่อ</legend>
        <div class="form-group">
            <?php echo Form::label('ที่อยู่ที่สามารถติดต่อได้', 'employee_addr', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::textarea('employee_addr', Input::post('employee_addr', isset($employee) ? $employee->employee_addr:''), array('class' => 'form-control', 'rows' => 3, 'placeholder' => 'ระบุที่อยู่ที่สามารถติดต่อได้')); ?>
            </div>
        </div>
        <div class="form-group" id="province-id">
            <?php echo Form::label('จังหวัด <span class="required">*</span>', 'province_id', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <select id="province_id" data-placeholder="ระบุจังหวัด" class="col-xs-12 col-sm-12 chzn-select" name="province_id">
                    <option value=""></option>
                    <?php foreach($provinces as $id => $title){ ?>
                        <option value="<?php echo $id; ?>" <?php if(isset($employee) && $id == $employee->province_id) { ?>selected="selected"<?php } ?>><?php echo $title; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('หมายเลขโทรศัพท์ <span class="required">*</span>', 'employee_phone', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('employee_phone', Input::post('employee_phone', isset($employee) ? $employee->employee_phone : ''), array('class' => 'form-control', 'placeholder' => 'ระบุหมายเลขโทรศัพท์')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('E-Mail <span class="required">*</span>', 'employee_email', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('employee_email', Input::post('employee_email', isset($employee) ? $employee->employee_email : ''), array('class' => 'form-control', 'placeholder' => 'ระบุ E-Mail')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('Website', 'employee_website', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('employee_website', Input::post('employee_website', isset($employee) ? $employee->employee_website : ''), array('class' => 'form-control', 'placeholder' => 'ระบุ Website')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('Facebook', 'employee_facebook', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('employee_facebook', Input::post('employee_facebook', isset($employee) ? $employee->employee_facebook : ''), array('class' => 'form-control', 'placeholder' => 'ระบุ Facebook')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('Twitter', 'employee_twitter', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('employee_twitter', Input::post('employee_twitter', isset($employee) ? $employee->employee_twitter : ''), array('class' => 'form-control', 'placeholder' => 'ระบุ Twitter')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('Google+', 'employee_gplus', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('employee_gplus', Input::post('employee_gplus', isset($employee) ? $employee->employee_gplus : ''), array('class' => 'form-control', 'placeholder' => 'ระบุ Google+')); ?>
            </div>
        </div>
        <legend class="section">ข้อมูลเกี่ยวกับการหางาน</legend>
        <div class="form-group">
            <?php echo Form::label('เกี่ยวกับผู้หางาน', 'employee_about', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::textarea('employee_about', Input::post('employee_about', isset($employee) ? $employee->employee_about:''), array('class' => 'form-control htmltextarea', 'rows' => 8, 'placeholder' => 'ระบุข้อมูลเกี่ยวกับผู้หางาน')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('ประเภทงานที่สนใจ <span class="required">*</span>', 'employee_prefer', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <div class="btn-group" data-toggle="buttons">
                    <label id="prefer_fulltime" class="btn btn-<?php echo (isset($employee)&&$employee->employee_prefer == "fulltime")?"primary":"default"; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input type="radio" name="employee_prefer" value="fulltime" <?php if(isset($employee) && $employee->employee_prefer == "fulltime"){ ?>checked="checked" <?php } ?>> Full-time
                    </label>
                    <label id="prefer_freelance" class="btn btn-<?php echo (isset($employee)&&$employee->employee_prefer == "freelance")?"primary":"default"; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input type="radio" name="employee_prefer" value="freelance" <?php if(isset($employee) && $employee->employee_prefer == "freelance"){ ?>checked="checked" <?php } ?>> Freelance
                    </label>
                    <label id="prefer_both" class="btn btn-<?php echo (isset($employee)&&$employee->employee_prefer == "both")?"primary":"default"; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input type="radio" name="employee_prefer" value="both" <?php if(isset($employee) && $employee->employee_prefer == "both"){ ?>checked="checked" <?php } ?>> Both
                    </label>
                </div>
            </div>
        </div>
        <?php if(isset($employee)) { ?>
            <div class="form-group">
                <?php echo Form::label('สถานะการทำงาน <span class="required">*</span>', 'working_status', array('class' => 'control-label')); ?>
                <div class="controls form-group">
                    <div class="btn-group" data-toggle="buttons">
                        <label id="working_1" class="btn btn-<?php echo (isset($custom)&&$custom->working_status == 1)?"primary":"default"; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                            <input type="radio" name="working_status" value="1" <?php if(isset($custom) && $custom->working_status == 1){ ?>checked="checked" <?php } ?>> ทำงานแล้ว
                        </label>
                        <label id="working_0" class="btn btn-<?php echo (isset($custom)&&$custom->working_status == 0)?"primary":"default"; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                            <input type="radio" name="working_status" value="0" <?php if(isset($custom) && $custom->working_status == 0){ ?>checked="checked" <?php } ?>> กำลังหางาน
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <?php echo Form::label('เผยแพร่เรซูเม่? <span class="required">*</span>', 'resume_published', array('class' => 'control-label')); ?>
                <div class="controls form-group">
                    <div class="btn-group" data-toggle="buttons">
                        <label id="resume_1" class="btn btn-<?php echo (isset($custom)&&$custom->resume_published == 1)?"primary":"default"; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                            <input type="radio" name="resume_published" value="1" <?php if(isset($custom) && $custom->resume_published == 1){ ?>checked="checked" <?php } ?>> เผยแพร่
                        </label>
                        <label id="resume_0" class="btn btn-<?php echo (isset($custom)&&$custom->resume_published == 0)?"primary":"default"; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                            <input type="radio" name="resume_published" value="0" <?php if(isset($custom) && $custom->resume_published == 0){ ?>checked="checked" <?php } ?>> ไม่เผยแพร่
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <?php echo Form::label('เผยแพร่แฟ้มผลงาน? <span class="required">*</span>', 'portfolio_published', array('class' => 'control-label')); ?>
                <div class="controls form-group">
                    <div class="btn-group" data-toggle="buttons">
                        <label id="portfolio_1" class="btn btn-<?php echo (isset($custom)&&$custom->portfolio_published == 1)?"primary":"default"; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                            <input type="radio" name="portfolio_published" value="1" <?php if(isset($custom) && $custom->portfolio_published == 1){ ?>checked="checked" <?php } ?>> เผยแพร่
                        </label>
                        <label id="portfolio_0" class="btn btn-<?php echo (isset($custom)&&$custom->portfolio_published == 0)?"primary":"default"; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                            <input type="radio" name="portfolio_published" value="0" <?php if(isset($custom) && $custom->portfolio_published == 0){ ?>checked="checked" <?php } ?>> ไม่เผยแพร่
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group" id="employee-is-active" <?php if(!isset($employee)) { ?>style="display:none;"<?php } ?>>
                <?php echo Form::label('สถานะผู้ใช้งาน', 'employee_is_active', array('class' => 'control-label')); ?>
                <div class="controls form-group">
                    <div class="btn-group" data-toggle="buttons">
                        <label id="active_1" class="btn btn-<?php echo (isset($employee)&&$employee->employee_is_active==1)?"primary":"default"; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                            <input type="radio" name="employee_is_active" value="1" <?php if(isset($employee) && $employee->employee_is_active == 1){ ?>checked="checked" <?php } ?>> ปกติ
                        </label>
                        <label id="active_0" class="btn btn-<?php echo (isset($employee)&&$employee->employee_is_active==0)?"danger":"default"; ?>" data-toggle-class="btn-danger" data-toggle-passive-class="btn-default">
                            <input type="radio" name="employee_is_active" value="0" <?php if(isset($employee) && $employee->employee_is_active == 0){ ?>checked="checked" <?php } ?>> ระงับ
                        </label>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="form-actions">
            <?php echo Form::submit('submit', 'บันทึก', array('class' => 'btn btn-success')); ?>
            <?php echo Form::button('clear', 'ยกเลิก', array('class' => 'btn btn-default')); ?>
        </div>
    <?php echo Form::fieldset_close(); ?></fieldset>
    <?php echo Form::close(); ?>
</div>