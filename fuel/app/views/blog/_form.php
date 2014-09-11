<header>
    <h4><i class="fa fa-bars"></i> ข้อมูลบล็อก</h4>
    <!--div class="actions">
        <button id="btn-expand" class="btn btn-xs btn-primary" onclick="expand();"><i class="fa fa-expand"></i> ขยายกรอบนี้</button>
        <button id="btn-compress" class="btn btn-xs btn-primary" style="display:none;" onclick="compress();"><i class="fa fa-compress"></i> ย่อกรอบนี้</button>
    </div-->
</header>
<div class="body">
    <?php echo Form::open(array("id" => "form-blog", "class" => "form-horizontal", "enctype" => "multipart/form-data")); ?>
    <?php echo Form::fieldset_open(); ?>
        <input type="hidden" name="action" value="edit_blog" />
        <div class="form-group">
            <?php echo Form::label('หัวข้อบล็อก <span class="required">*</span>', 'blog_title', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('blog_title', Input::post('blog_title', isset($blog) ? $blog->blog_title : ''), array('class' => 'form-control', 'placeholder' => 'ระบุหัวข้อบล็อก')); ?>
                <p class="help-block">ไม่เกิน 255 ตัวอักษร</p>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('เนื้อหาแบบย่อ', 'blog_short_detail', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::textarea('blog_short_detail', Input::post('blog_short_detail', isset($blog) ? $blog->blog_short_detail : ''), array('class' => 'form-control', 'rows' => 8, 'placeholder' => 'ระบุเนื้อหาแบบย่อ')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('เนื้อหา', 'blog_detail', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::textarea('blog_detail', Input::post('blog_detail', isset($blog) ? $blog->blog_detail : ''), array('class' => 'form-control htmltextarea', 'rows' => 20, 'placeholder' => 'ระบุเนื้อหา')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('ไฟล์ภาพ Cover', 'blog_cover_photo', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <span class="btn btn-default fileinput-button">
                    <i class="fa fa-plus"></i>
                    <span id="cover-photo-file-name">เลือกไฟล์ภาพ</span>
                    <input id="cover-photo-file" type="file" name="blog_cover_photo_file" accept="image/*" />
                </span>
                <p class="help-block">รองรับไฟล์ .jpg และ .png และภาพควรมีขนาด 750 x 267 pixel</p>
            </div>
            <div class="controls form-group">
                <div style="width:375px;height:134px;overflow:hidden;">
                    <img id="cover-photo-preview" src="<?php echo (isset($blog) && strlen($blog->blog_cover_photo))?"http://www.buffohero.com/uploads/blog_cover/".$blog->blog_cover_photo:"http://placehold.it/750x267/fff.png"; ?>" border="0" style="width:375px;height:auto;" />
                </div>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('สถานะ', 'blog_published', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <div class="btn-group" data-toggle="buttons">
                    <label id="active_1" class="btn btn-<?php echo (isset($blog)&&$blog->blog_published==1)?"primary":"default"; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input type="radio" name="blog_published" value="1" <?php if(isset($blog) && $blog->blog_published == 1){ ?>checked="checked" <?php } ?>> เผยแพร่
                    </label>
                    <label id="active_0" class="btn btn-<?php echo (!isset($blog) || isset($blog)&&$blog->blog_published==0)?"danger":"default"; ?>" data-toggle-class="btn-danger" data-toggle-passive-class="btn-default">
                        <input type="radio" name="blog_published" value="0" <?php if(!isset($blog) || isset($blog)&&$blog->blog_published==0){ ?>checked="checked" <?php } ?>> ระงับ
                    </label>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <a class="btn btn-success" href="javascript:void(0);" onclick="$('#form-blog').submit();">Save</a>
            <a class="btn btn-default" href="<?php echo Uri::create('blog'); ?>">Cancel</a>
        </div>
    <?php echo Form::fieldset_close(); ?></fieldset>
    <?php echo Form::close(); ?>
</div>