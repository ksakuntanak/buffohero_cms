<div class="body">
    <?php echo Form::open(array("class" => "form-horizontal","enctype" => "multipart/form-data")); ?>
    <?php echo Form::fieldset_open(); ?>
        <legend class="section">ข้อมูลผู้ว่าจ้าง</legend>
        <div class="form-group" id="employer-name">
            <?php echo Form::label('ชื่อผู้ว่าจ้าง <span class="required">*</span>', 'employer_name', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('employer_name', Input::post('employer_name', isset($employer) ? $employer->employer_name : ''), array('class' => 'form-control', 'placeholder' => 'ระบุชื่อผู้ว่าจ้าง')); ?>
                <p class="help-block">ไม่เกิน 255 ตัวอักษร</p>
            </div>
        </div>
        <div class="form-group" id="employer-desc">
            <?php echo Form::label('รายละเอียด', 'employer_desc', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::textarea('employer_desc', Input::post('employer_desc', isset($employer) ? $employer->employer_desc : ''), array('class' => 'form-control htmltextarea', 'rows' => 5, 'placeholder' => 'ระบุรายละเอียด')); ?>
            </div>
        </div>
        <div class="form-group" id="employer-addr">
            <?php echo Form::label('ที่อยู่', 'employer_addr', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::textarea('employer_addr', Input::post('employer_addr', isset($employer) ? $employer->employer_addr : ''), array('class' => 'form-control', 'rows' => 3, 'placeholder' => 'ระบุที่อยู่')); ?>
            </div>
        </div>
        <div class="form-group" id="province-id">
            <?php echo Form::label('จังหวัด <span class="required">*</span>', 'province_id', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <select id="province_id" data-placeholder="ระบุจังหวัด" class="col-xs-12 col-sm-12 chzn-select" name="province_id">
                    <option value=""></option>
                    <?php foreach($provinces as $id => $title){ ?>
                        <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group" id="employer-tel">
            <?php echo Form::label('หมายเลขโทรศัพท์ <span class="required">*</span>', 'employer_tel', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('employer_tel', Input::post('employer_tel', isset($employer) ? $employer->employer_tel : ''), array('class' => 'form-control', 'placeholder' => 'ระบุหมายเลขโทรศัพท์')); ?>
            </div>
        </div>
        <div class="form-group" id="employer-fax">
            <?php echo Form::label('หมายเลขโทรสาร', 'employer_fax', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('employer_fax', Input::post('employer_fax', isset($employer) ? $employer->employer_fax : ''), array('class' => 'form-control', 'placeholder' => 'ระบุหมายเลขโทรสาร')); ?>
            </div>
        </div>
        <div class="form-group" id="employer-email">
            <?php echo Form::label('E-Mail <span class="required">*</span>', 'employer_email', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('employer_email', Input::post('employer_email', isset($employer) ? $employer->employer_email : ''), array('class' => 'form-control', 'placeholder' => 'ระบุ E-Mail')); ?>
            </div>
        </div>
        <div class="form-group" id="employer-website">
            <?php echo Form::label('Website', 'employer_website', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('employer_website', Input::post('employer_website', isset($employer) ? $employer->employer_website : ''), array('class' => 'form-control', 'placeholder' => 'ระบุ Website')); ?>
            </div>
        </div>
        <div class="form-group" id="employer-photo">
            <?php echo Form::label('ไฟล์ภาพ Logo', 'employer_photo_file', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <span class="btn btn-default fileinput-button">
                    <i class="fa fa-plus"></i>
                    <span id="photo-file-name">เลือกไฟล์ภาพ</span>
                    <input id="photo-file" type="file" name="employer_photo_file" accept="image/*" />
                </span>
                <p class="help-block">รองรับไฟล์ .jpg และ .png รูปควรมีขนาด 466 x 360 pixel</p>
            </div>
            <div class="controls form-group">
                <div style="width:233px;height:180px;overflow:hidden;">
                    <img id="photo-preview" src="<?php echo (isset($employer) && strlen($employer->employer_photo))?"http://www.buffohero.com/uploads/profile_photo/employer/".$employer->employer_photo:"http://placehold.it/233x180/ccc.png"; ?>" border="0" style="width:233px;" />
                </div>
            </div>
        </div>
        <legend class="section">ข้อมูลงาน</legend>
        <div class="form-group" id="job-type">
            <?php echo Form::label('ประเภทงาน <span class="required">*</span>', 'job_type', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <div class="btn-group" data-toggle="buttons">
                    <label id="type-fulltime" class="btn btn-<?php echo (isset($job)&&$job->job_type=="fulltime")?"primary":"default"; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input type="radio" name="job_type" value="fulltime" <?php if(isset($job) && $job->job_type == "fulltime"){ ?>checked="checked" <?php } ?>> Full-time
                    </label>
                    <label id="type-project" class="btn btn-<?php echo (isset($job)&&$job->job_type=="project")?"primary":"default"; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input type="radio" name="job_type" value="project" <?php if(isset($job) && $job->job_type == "project"){ ?>checked="checked" <?php } ?>> Project / Campaign
                    </label>
                    <label id="type-contest" class="btn btn-<?php echo (isset($job)&&$job->job_type=="contest")?"primary":"default"; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input type="radio" name="job_type" value="contest" <?php if(isset($job) && $job->job_type == "contest"){ ?>checked="checked" <?php } ?>> Contest
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group" id="job-title-fulltime" <?php if(!isset($job) || $job->job_type!="fulltime") { ?>style="display:none;"<?php } ?>>
            <?php echo Form::label('ชื่อตำแหน่งงาน <span class="required">*</span>', 'job_title', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('job_title_fulltime', Input::post('job_title', isset($job) ? $job->job_title : ''), array('class' => 'form-control', 'placeholder' => 'ระบุชื่อตำแหน่งงาน')); ?>
                <p class="help-block">ไม่เกิน 255 ตัวอักษร</p>
            </div>
        </div>
        <div class="form-group" id="job-title-project" <?php if(!isset($job) || $job->job_type!="project") { ?>style="display:none;"<?php } ?>>
            <?php echo Form::label('ชื่อโครงการ <span class="required">*</span>', 'job_title', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('job_title_project', Input::post('job_title', isset($job) ? $job->job_title : ''), array('class' => 'form-control', 'placeholder' => 'ระบุชื่อโครงการ')); ?>
                <p class="help-block">ไม่เกิน 255 ตัวอักษร</p>
            </div>
        </div>
        <div class="form-group" id="job-title-contest" <?php if(!isset($job) || $job->job_type!="contest") { ?>style="display:none;"<?php } ?>>
            <?php echo Form::label('ชื่อการประกวด <span class="required">*</span>', 'job_title', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('job_title_contest', Input::post('job_title', isset($job) ? $job->job_title : ''), array('class' => 'form-control', 'placeholder' => 'ระบุชื่อการประกวด')); ?>
                <p class="help-block">ไม่เกิน 255 ตัวอักษร</p>
            </div>
        </div>
        <div class="form-group" id="job-cat-id" <?php if(!isset($job)) { ?>style="display:none;"<?php } ?>>
            <?php echo Form::label('หมวดหมู่ <span class="required">*</span>', 'cat_id', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <select id="cat_id" data-placeholder="ระบุหมวดหมู่" class="col-xs-12 col-sm-12 chzn-select" name="cat_id">
                    <option value=""></option>
                    <?php foreach($cats as $id => $title){ ?>
                        <option value="<?php echo $id; ?>" <?php if(isset($job)&&$id==$job->cat_id) { ?>selected="selected"<?php } ?>><?php echo $title; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group" id="job-subcat-id" <?php if(!isset($job)) { ?>style="display:none;"<?php } ?>>
            <?php echo Form::label('หมวดหมู่ย่อย <span class="required">*</span>', 'cat_id', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <select id="subcat_id" data-placeholder="ระบุหมวดหมู่ย่อย" class="col-xs-12 col-sm-12 chzn-select" name="subcat_id">
                    <option value=""></option>
                    <?php if(count($current_subcats)) { ?>
                        <?php foreach($current_subcats as $id => $title){ ?>
                            <option value="<?php echo $id; ?>" <?php if(isset($job)&&$id==$job->subcat_id) { ?>selected="selected"<?php } ?>><?php echo $title; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group" id="job-desc" <?php if(!isset($job)) { ?>style="display:none;"<?php } ?>>
            <?php echo Form::label('รายละเอียด', 'job_desc', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::textarea('job_desc', Input::post('job_desc', isset($job) ? $job->job_desc : ''), array('class' => 'form-control htmltextarea', 'rows' => 8, 'placeholder' => 'ระบุรายละเอียด', 'id' => 'htmltextarea')); ?>
            </div>
        </div>
        <div class="form-group" id="job-qualifications" <?php if(!isset($job) || $job->job_type!="fulltime") { ?>style="display:none;"<?php } ?>>
            <?php echo Form::label('คุณสมบัติ', 'job_qualifications', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('job_qualifications', Input::post('job_qualifications', isset($job) ? $job->job_qualifications : ''), array('class' => 'form-control', 'placeholder' => 'ระบุคุณสมบัติ')); ?>
                <p class="help-block">คั่นแต่ละคุณสมบัติด้วย comma (,)</p>
            </div>
        </div>
        <div class="form-group" id="job-skills" <?php if(!isset($job)) { ?>style="display:none;"<?php } ?>>
            <?php echo Form::label('ทักษะที่จำเป็น', 'job_skills', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('job_skills', Input::post('job_skills', isset($job) ? $job->job_skills : ''), array('class' => 'form-control', 'placeholder' => 'ระบุทักษะ')); ?>
                <p class="help-block">คั่นแต่ละทักษะด้วย comma (,)</p>
            </div>
        </div>
        <div class="form-group" id="job-tags" <?php if(!isset($job)) { ?>style="display:none;"<?php } ?>>
            <?php echo Form::label('แท็ก', 'job_tags', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('job_tags', Input::post('job_tags', isset($job) ? $job->job_tags : ''), array('class' => 'form-control', 'placeholder' => 'ระบุแท็ก')); ?>
                <p class="help-block">คั่นแต่ละทักษะด้วย comma (,)</p>
            </div>
        </div>
        <div class="form-group" id="job-position" <?php if(!isset($job) || $job->job_type!="fulltime") { ?>style="display:none;"<?php } ?>>
            <?php echo Form::label('จำนวนที่รับ <span class="required">*</span>', 'job_position', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('job_position', Input::post('job_position', isset($job) ? $job->job_position : ''), array('class' => 'form-control', 'placeholder' => 'ระบุจำนวนที่รับ (เป็นตัวเลข)')); ?>
            </div>
        </div>
        <div class="form-group" id="job-areas" <?php if(!isset($job) || $job->job_type!="fulltime") { ?>style="display:none;"<?php } ?>>
            <?php echo Form::label('เขตอำเภอ/จังหวัดที่ทำงาน', 'job_areas', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('job_areas', Input::post('job_areas', isset($job) ? $job->job_areas : ''), array('class' => 'form-control', 'placeholder' => 'ระบุเขตอำเภอ/จังหวัดที่ทำงาน')); ?>
                <p class="help-block">คั่นแต่ละเขตด้วย comma (,)</p>
            </div>
        </div>
        <div class="form-group" id="job-salary" <?php if(!isset($job) || $job->job_type!="fulltime") { ?>style="display:none;"<?php } ?>>
            <?php echo Form::label('เงินเดือน <span class="required">*</span>', 'job_salary', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('job_salary', Input::post('job_salary', isset($job) ? $job->job_salary : ''), array('class' => 'form-control', 'placeholder' => 'ระบุเงินเดือน')); ?>
                <p class="help-block">กรอกได้ทั้งตัวเลขและตัวหนังสือ เช่น 18000 Baht, Start from 15000 Baht (ไม่เกิน 255 ตัวอักษร)</p>
            </div>
        </div>
        <div class="form-group" id="job-welfare" <?php if(!isset($job) || $job->job_type!="fulltime") { ?>style="display:none;"<?php } ?>>
            <?php echo Form::label('สวัสดิการ', 'job_welfare', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('job_welfare', Input::post('job_welfare', isset($job) ? $job->job_welfare : ''), array('class' => 'form-control', 'placeholder' => 'ระบุสวัสดิการ')); ?>
                <p class="help-block">คั่นแต่ละสวัสดิการด้วย comma (,)</p>
            </div>
        </div>
        <div class="form-group" id="job-budget" <?php if(!isset($job) || $job->job_type!="project") { ?>style="display:none;"<?php } ?>>
            <?php echo Form::label('งบประมาณ/ค่าแรง <span class="required">*</span>', 'job_budget', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('job_budget', Input::post('job_budget', isset($job) ? $job->job_budget : ''), array('class' => 'form-control', 'placeholder' => 'ระบุงบประมาณ/ค่าแรง')); ?>
                <p class="help-block">กรอกได้ทั้งตัวเลขและตัวหนังสือ เช่น 50000 Baht, 1000 Baht/Page (ไม่เกิน 255 ตัวอักษร)</p>
            </div>
        </div>
        <div class="form-group" id="job-prize" <?php if(!isset($job) || $job->job_type!="contest") { ?>style="display:none;"<?php } ?>>
            <?php echo Form::label('รางวัล <span class="required">*</span>', 'job_prize', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('job_prize', Input::post('job_prize', isset($job) ? $job->job_prize : ''), array('class' => 'form-control', 'placeholder' => 'ระบุรางวัล')); ?>
                <p class="help-block">กรอกได้ทั้งตัวเลขและตัวหนังสือ เช่น 20000 Baht with Certificate (ไม่เกิน 255 ตัวอักษร)</p>
            </div>
        </div>
        <div class="form-group" id="job-attachment">
            <?php echo Form::label('ไฟล์แนบ', 'job_attachment_file', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                    <span class="btn btn-default fileinput-button">
                        <i class="fa fa-plus"></i>
                        <span id="job-attachment-file-name">เลือกไฟล์แนบ</span>
                        <input id="job-attachment-file" type="file" name="job_attachment_file" accept="application/pdf,application/msword" />
                    </span>
                <p class="help-block">รองรับไฟล์ .doc และ .pdf</p>
            </div>
            <?php if(isset($job) && strlen($job->job_attachment)) { ?>
            <div class="controls form-group">
                <a href="<?php echo "http://www.buffohero.com/uploads/job_attachment/".$job->job_attachment; ?>"><?php echo $job->job_attachment; ?></a>
            </div>
            <?php } ?>
        </div>
        <div class="form-group" id="job-is-featured" <?php if(!isset($job)) { ?>style="display:none;"<?php } ?>>
            <?php echo Form::label('แนะนำ (Featured)', 'job_is_featured', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <div class="btn-group" data-toggle="buttons">
                    <label id="featured_1" class="btn btn-<?php echo (isset($job)&&$job->job_is_featured==1)?"primary":"default"; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input type="radio" name="job_is_featured" value="1" <?php if(isset($job) && $job->job_is_featured == 1){ ?>checked="checked" <?php } ?>> ใช่
                    </label>
                    <label id="featured_0" class="btn btn-<?php echo (isset($job)&&$job->job_is_featured==0)?"danger":"default"; ?>" data-toggle-class="btn-danger" data-toggle-passive-class="btn-default">
                        <input type="radio" name="job_is_featured" value="0" <?php if(isset($job) && $job->job_is_featured == 0){ ?>checked="checked" <?php } ?>> ไม่ใช่
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group" id="job-is-urgent" <?php if(!isset($job)) { ?>style="display:none;"<?php } ?>>
            <?php echo Form::label('เร่งด่วน (Urgent)', 'job_is_urgent', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <div class="btn-group" data-toggle="buttons">
                    <label id="urgent_1" class="btn btn-<?php echo (isset($job)&&$job->job_is_urgent==1)?"primary":"default"; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input type="radio" name="job_is_urgent" value="1" <?php if(isset($job) && $job->job_is_urgent == 1){ ?>checked="checked" <?php } ?>> ใช่
                    </label>
                    <label id="urgent_0" class="btn btn-<?php echo (isset($job)&&$job->job_is_urgent==0)?"danger":"default"; ?>" data-toggle-class="btn-danger" data-toggle-passive-class="btn-default">
                        <input type="radio" name="job_is_urgent" value="0" <?php if(isset($job) && $job->job_is_urgent == 0){ ?>checked="checked" <?php } ?>> ไม่ใช่
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group" id="job-is-active" <?php if(!isset($job)) { ?>style="display:none;"<?php } ?>>
            <?php echo Form::label('สถานะ', 'job_is_active', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <div class="btn-group" data-toggle="buttons">
                    <label id="active_1" class="btn btn-<?php echo (isset($job)&&$job->job_is_active==2)?"primary":"default"; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input type="radio" name="job_is_active" value="2" <?php if(isset($job) && $job->job_is_active == 2){ ?>checked="checked" <?php } ?>> เผยแพร่
                    </label>
                    <label id="active_1" class="btn btn-<?php echo (isset($job)&&$job->job_is_active==1)?"primary":"default"; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input type="radio" name="job_is_active" value="1" <?php if(isset($job) && $job->job_is_active == 1){ ?>checked="checked" <?php } ?>> รอการอนุมัติ
                    </label>
                    <label id="active_0" class="btn btn-<?php echo (isset($job)&&$job->job_is_active==0)?"danger":"default"; ?>" data-toggle-class="btn-danger" data-toggle-passive-class="btn-default">
                        <input type="radio" name="job_is_active" value="0" <?php if(isset($job) && $job->job_is_active == 0){ ?>checked="checked" <?php } ?>> ระงับ
                    </label>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-success')); ?>
            <?php echo Form::button('clear', 'Cancel', array('class' => 'btn btn-default', 'type' => 'button')); ?>
        </div>
    <?php echo Form::fieldset_close(); ?></fieldset>
    <?php echo Form::close(); ?>
</div>
<script type="text/javascript">
    var subcats = <?php echo html_entity_decode($subcats); ?>;
</script>