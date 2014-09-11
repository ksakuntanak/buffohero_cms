<div class="body">
    <?php echo Form::open(array("class" => "form-horizontal","enctype" => "multipart/form-data")); ?>
    <?php echo Form::hidden('created_date', Input::post('created_date', isset($employer) ? $employer->created_date:'')); ?>
    <?php echo Form::hidden('last_login', Input::post('last_login', isset($employer) ? $employer->last_login:'')); ?>
    <?php echo Form::hidden('login_hash', Input::post('login_hash', isset($employer) ? $employer->login_hash:'')); ?>
    <?php echo Form::hidden('employer_logo_file', Input::post('employer_logo_file', isset($employer) ? $employer->employer_logo_file:'')); ?>
    <?php echo Form::fieldset_open(); ?>
        <legend class="section">ข้อมูลบัญชีผู้ใช้งาน</legend>
        <div class="form-group">
            <?php echo Form::label('Username <span class="required">*</span>', 'username', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('username', Input::post('username', isset($employer) ? $employer->username : ''), array('class' => 'form-control', 'placeholder' => 'ระบุ Username')); ?>
                <span class="help-block">ความยาว 8 - 20 ตัวอักษร</span>
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
            <?php echo Form::label('ชื่อบริษัทผู้ว่าจ้าง <span class="required">*</span>', 'employer_name', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('employer_name', Input::post('employer_name', isset($employer) ? $employer->employer_name:''), array('class' => 'form-control', 'placeholder' => 'ระบุชื่อตำแหน่งงาน')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('รายละเอียด', 'employer_desc', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::textarea('employer_desc', Input::post('employer_desc', isset($employer) ? $employer->employer_desc:''), array('class' => 'form-control', 'rows' => 8, 'placeholder' => 'ระบุรายละเอียด')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('ที่อยู่ <span class="required">*</span>', 'employer_addr', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::textarea('employer_addr', Input::post('employer_addr', isset($employer) ? $employer->employer_addr:''), array('class' => 'form-control', 'rows' => 3, 'placeholder' => 'ระบุสวัสดิการ')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('โทรศัพท์ <span class="required">*</span>', 'employer_tel', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('employer_tel', Input::post('employer_tel', isset($employer) ? $employer->employer_tel : ''), array('class' => 'form-control', 'placeholder' => 'ระบุหมายเลขโทรศัพท์')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('โทรสาร', 'employer_fax', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('employer_fax', Input::post('employer_fax', isset($employer) ? $employer->employer_fax : ''), array('class' => 'form-control', 'placeholder' => 'ระบุหมายเลขโทรสาร')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('E-Mail <span class="required">*</span>', 'employer_email', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('employer_email', Input::post('employer_email', isset($employer) ? $employer->employer_email : ''), array('class' => 'form-control', 'placeholder' => 'ระบุ E-Mail')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('Website', 'employer_website', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('employer_website', Input::post('employer_website', isset($employer) ? $employer->employer_website : ''), array('class' => 'form-control', 'placeholder' => 'ระบุ Website')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('ไฟล์ภาพ Logo <span class="required">*</span>', 'employer_logo', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <span class="btn btn-default fileinput-button">
                    <i class="fa fa-plus"></i>
                    <span>เลือกไฟล์รูปภาพ</span>
                    <input type="file" name="employer_logo">
                </span>
                <span class="help-block">เป็นไฟล์ภาพ .png ขนาด 400 x 400 pixel</span>
            </div>
        </div>
        <?php if(isset($employer)) { ?>
        <div class="form-group">
            <?php echo Form::label('ไฟล์ภาพ Logo ที่มีอยู่', 'employer_logo_file', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <img src="<?php echo Uri::base(false); ?>/public/uploads/<?php echo $employer->employer_logo_file; ?>" border="0" style="width:400px;" />
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