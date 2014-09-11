<div class="body">
    <?php echo Form::open(array("class" => "form-horizontal","enctype" => "multipart/form-data")); ?>
    <?php echo Form::hidden('created_date', Input::post('created_date', isset($employee) ? $employee->created_date:'')); ?>
    <?php echo Form::hidden('last_login', Input::post('last_login', isset($employee) ? $employee->last_login:'')); ?>
    <?php echo Form::hidden('login_hash', Input::post('login_hash', isset($employee) ? $employee->login_hash:'')); ?>
    <?php echo Form::fieldset_open(); ?>
        <legend class="section">ข้อมูลบัญชีผู้ใช้งาน</legend>
        <div class="form-group">
            <?php echo Form::label('E-Mail <span class="required">*</span>', 'username', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('username', Input::post('username', isset($employee) ? $employee->username : ''), array('class' => 'form-control', 'placeholder' => 'ระบุ E-Mail')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('Password'.($menu=="create"?' <span class="required">*</span>':''), 'password', array('class' => 'control-label')); ?>
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
            <?php echo Form::label('คำนำหน้า <span class="required">*</span>', 'employee_title', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <div class="btn-group" data-toggle="buttons">
                    <label id="title_mr" class="btn btn-<?php echo (isset($employee)&&$employee->employee_title=="mr")?"primary":"default"; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input type="radio" name="employee_title" value="mr" <?php if(isset($employee) && $employee->employee_title == "mr"){ ?>checked="checked" <?php } ?>> นาย
                    </label>
                    <label id="title_mrs" class="btn btn-<?php echo (isset($employee)&&$employee->employee_title=="mrs")?"primary":"default"; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input type="radio" name="employee_title" value="mrs" <?php if(isset($employee) && $employee->employee_title == "mrs"){ ?>checked="checked" <?php } ?>> นาง
                    </label>
                    <label id="title_ms" class="btn btn-<?php echo (isset($employee)&&$employee->employee_title=="ms")?"primary":"default"; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input type="radio" name="employee_title" value="ms" <?php if(isset($employee) && $employee->employee_title == "ms"){ ?>checked="checked" <?php } ?>> นางสาว
                    </label>
                    <label id="title_other" class="btn btn-<?php echo (isset($employee)&&$employee->employee_title=="other")?"primary":"default"; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input type="radio" name="employee_title" value="other" <?php if(isset($employee) && $employee->employee_title == "other"){ ?>checked="checked" <?php } ?>> อื่นๆ
                    </label>
                </div>
            </div>
            <div class="controls form-group col-sm-4" id="title_other_box" style="display:<?php echo (isset($employee)&&$employee->employee_title=="other")?"block":"none"; ?>;">
                <?php echo Form::input('employee_other_title', Input::post('employee_other_title', isset($employee)?$employee->employee_other_title:''), array('class' => 'form-control', 'placeholder' => 'ระบุคำนำหน้า')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('ชื่อ <span class="required">*</span>', 'employee_first_name', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('employee_first_name', Input::post('employee_first_name', isset($employee) ? $employee->employee_first_name:''), array('class' => 'form-control', 'placeholder' => 'ระบุชื่อ')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('นามสกุล <span class="required">*</span>', 'employee_last_name', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('employee_last_name', Input::post('employee_last_name', isset($employee) ? $employee->employee_last_name:''), array('class' => 'form-control', 'placeholder' => 'ระบุนามสกุล')); ?>
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
            <?php echo Form::label('สัญชาติ <span class="required">*</span>', 'employee_nationality', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <div class="btn-group" data-toggle="buttons">
                    <label id="nation_thai" class="btn btn-<?php echo (isset($employee)&&$employee->employee_nationality=="thai")?"primary":"default"; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input type="radio" name="employee_nationality" value="thai" <?php if(isset($employee) && $employee->employee_nationality == "thai"){ ?>checked="checked" <?php } ?>> ไทย
                    </label>
                    <label id="nation_other" class="btn btn-<?php echo (isset($employee)&&$employee->employee_nationality=="other")?"primary":"default"; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input type="radio" name="employee_nationality" value="other" <?php if(isset($employee) && $employee->employee_nationality == "other"){ ?>checked="checked" <?php } ?>> อื่นๆ
                    </label>
                </div>
            </div>
            <div class="controls form-group col-sm-4" id="nation_other_box" style="display:<?php echo (isset($employee)&&$employee->employee_other_nationality=="other")?"block":"none"; ?>;">
                <?php echo Form::input('employee_other_nationality', Input::post('employee_other_nationality', isset($employee)?$employee->employee_other_nationality:''), array('class' => 'form-control', 'placeholder' => 'ระบุสัญชาติ')); ?>
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
            <?php echo Form::label('ที่อยู่ที่สามารถติดต่อได้ <span class="required">*</span>', 'employee_addr', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::textarea('employee_addr', Input::post('employee_addr', isset($employee) ? $employee->employee_addr:''), array('class' => 'form-control', 'rows' => 3, 'placeholder' => 'ระบุที่อยู่ที่สามารถติดต่อได้')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('ประเทศ <span class="required">*</span>', 'employee_country', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <select id="country" data-placeholder="ระบุประเทศ" class="col-xs-12 col-sm-6 chzn-select" name="employee_country">
                    <option value=""></option>
                    <?php foreach($countries as $c){ ?>
                        <option value="<?php echo $c; ?>" <?php if(isset($employee)&&$employee->employee_country==$c){ ?>selected="selected"<?php } ?>><?php echo $c; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('หมายเลขโทรศัพท์มือถือ <span class="required">*</span>', 'employee_mobile', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('employee_mobile', Input::post('employee_mobile', isset($employee) ? $employee->employee_mobile : ''), array('id' => "mobile", 'class' => 'form-control', 'placeholder' => 'ระบุหมายเลขโทรศัพท์มือถือ')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('หมายเลขโทรศัพท์บ้าน', 'employee_phone', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('employee_phone', Input::post('employee_phone', isset($employee) ? $employee->employee_phone : ''), array('class' => 'form-control', 'placeholder' => 'ระบุหมายเลขโทรศัพท์บ้าน')); ?>
            </div>
        </div>
        <legend class="section">ข้อมูลเกี่ยวกับการหางาน</legend>
        <div class="form-group">
            <?php echo Form::label('ประเภทงานที่สนใจ <span class="required">*</span>', 'employee_job_type', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <div class="btn-group" data-toggle="buttons">
                    <label id="gender_m" class="btn btn-<?php echo (isset($employee)&&$employee->employee_job_type=="full-time")?"primary":"default"; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input type="radio" name="employee_job_type" value="full-time" <?php if(isset($employee) && $employee->employee_job_type == "full-time"){ ?>checked="checked" <?php } ?>> Full-time
                    </label>
                    <label id="gender_f" class="btn btn-<?php echo (isset($employee)&&$employee->employee_job_type=="freelance")?"primary":"default"; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input type="radio" name="employee_job_type" value="freelance" <?php if(isset($employee) && $employee->employee_job_type == "freelance"){ ?>checked="checked" <?php } ?>> Freelance
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('สาขางานที่สนใจ', 'employee_keywords', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <select data-placeholder="ระบุคำสำคัญสำหรับค้นหางาน" class="chzn-select select-block-level" tabindex="-1" multiple="multiple" id="multiple" name="employee_keywords[]">
                    <?php
                        if(isset($employee)) $keywords = explode(",",$employee->employee_keywords);
                        else $keywords = array();
                    ?>
                    <?php foreach($cats as $c){ ?>
                        <option value="<?php echo $c; ?>" <?php if(in_array($c,$keywords)){ ?>selected="selected"<?php } ?>><?php echo $c; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('เกี่ยวกับผู้หางาน <span class="required">*</span>', 'employee_about', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::textarea('employee_about', Input::post('employee_about', isset($employee) ? $employee->employee_about:''), array('class' => 'form-control', 'rows' => 8, 'placeholder' => 'ระบุข้อมูลเกี่ยวกับผู้หางาน')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('ทักษะ / ความสามารถ <span class="required">*</span>', 'employee_skills', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::textarea('employee_skills', Input::post('employee_skills', isset($employee) ? $employee->employee_skills:''), array('class' => 'form-control', 'rows' => 8, 'placeholder' => 'ระบุทักษะ / ความสามารถ')); ?>
            </div>
        </div>
        <div class="form-actions">
            <?php echo Form::submit('submit', 'บันทึก', array('class' => 'btn btn-success')); ?>
            <?php echo Form::button('clear', 'ยกเลิก', array('class' => 'btn btn-default')); ?>
        </div>
    <?php echo Form::fieldset_close(); ?></fieldset>
    <?php echo Form::close(); ?>
</div>