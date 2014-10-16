<div class="body">
    <?php echo Form::open(array("action"=>"","class"=>"form-horizontal","method"=>"post","enctype" => "multipart/form-data")); ?>
    <?php echo Form::hidden('user_id',Input::post('user_id',isset($employer)?$employer->user_id:0)); ?>
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
            <?php echo Form::label('ชื่อบริษัทผู้ว่าจ้าง <span class="required">*</span>', 'employer_name', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('employer_name', Input::post('employer_name', isset($employer) ? $employer->employer_name:''), array('class' => 'form-control', 'placeholder' => 'ระบุชื่อตำแหน่งงาน')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('รายละเอียด', 'employer_desc', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::textarea('employer_desc', Input::post('employer_desc', isset($employer) ? $employer->employer_desc:''), array('class' => 'form-control  htmltextarea', 'rows' => 8, 'placeholder' => 'ระบุรายละเอียด', 'id' => 'htmltextarea')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('ที่อยู่', 'employer_addr', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::textarea('employer_addr', Input::post('employer_addr', isset($employer) ? $employer->employer_addr:''), array('class' => 'form-control', 'rows' => 3, 'placeholder' => 'ระบุที่อยู่')); ?>
            </div>
        </div>
        <div class="form-group" id="province-id">
            <?php echo Form::label('จังหวัด <span class="required">*</span>', 'province_id', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <select id="province_id" data-placeholder="ระบุจังหวัด" class="col-xs-12 col-sm-12 chzn-select" name="province_id">
                    <option value=""></option>
                    <?php foreach($provinces as $id => $title){ ?>
                        <option value="<?php echo $id; ?>" <?php if(isset($employer) && $id == $employer->province_id) { ?>selected="selected"<?php } ?>><?php echo $title; ?></option>
                    <?php } ?>
                </select>
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
            <?php echo Form::label('รูปโปรไฟล์ <span class="required">*</span>','employer_photo_file', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <span class="btn btn-default fileinput-button">
                    <i class="fa fa-plus"></i>
                    <span>เลือกไฟล์รูปภาพ</span>
                    <input type="file" name="employer_photo_file">
                </span>
                <span class="help-block">เป็นไฟล์ภาพ .png ขนาด 466 x 360 pixel</span>
            </div>
        </div>
        <?php if(isset($employer) && strlen($employer->employer_photo)) { ?>
        <div class="form-group">
            <?php echo Form::label('ไฟล์ภาพ Logo ที่มีอยู่','employer_photo_file_file', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <img src="//buffohero.com/uploads/profile_photo/employer/<?php echo $employer->employer_photo; ?>" border="0" style="width:400px;" />
            </div>
        </div>
        <?php } ?>
        <?php if(isset($employer)) { ?>
        <div class="form-group" id="employer-is-active" <?php if(!isset($employer)) { ?>style="display:none;"<?php } ?>>
            <?php echo Form::label('สถานะ', 'employer_is_active', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <div class="btn-group" data-toggle="buttons">
                    <label id="active_1" class="btn btn-<?php echo (isset($employer)&&$employer->employer_is_active==1)?"primary":"default"; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input type="radio" name="employer_is_active" value="1" <?php if(isset($employer) && $employer->employer_is_active == 1){ ?>checked="checked" <?php } ?>> ปกติ
                    </label>
                    <label id="active_0" class="btn btn-<?php echo (isset($employer)&&$employer->employer_is_active==0)?"danger":"default"; ?>" data-toggle-class="btn-danger" data-toggle-passive-class="btn-default">
                        <input type="radio" name="employer_is_active" value="0" <?php if(isset($employer) && $employer->employer_is_active == 0){ ?>checked="checked" <?php } ?>> ระงับ
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