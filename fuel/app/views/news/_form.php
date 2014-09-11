<header>
    <h4><i class="fa fa-bars"></i> ข้อมูลข่าว</h4>
    <!--div class="actions">
        <button id="btn-expand" class="btn btn-xs btn-primary" onclick="expand();"><i class="fa fa-expand"></i> ขยายกรอบนี้</button>
        <button id="btn-compress" class="btn btn-xs btn-primary" style="display:none;" onclick="compress();"><i class="fa fa-compress"></i> ย่อกรอบนี้</button>
    </div-->
</header>
<div class="body">
    <?php echo Form::open(array("id" => "form-news", "class" => "form-horizontal", "enctype" => "multipart/form-data")); ?>
    <?php echo Form::fieldset_open(); ?>
        <input type="hidden" name="action" value="edit_news" />
        <div class="form-group">
            <?php echo Form::label('หัวข้อข่าว <span class="required">*</span>', 'news_title', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('news_title', Input::post('news_title', isset($news) ? $news->news_title : ''), array('class' => 'form-control', 'placeholder' => 'ระบุหัวข้อข่าว')); ?>
                <p class="help-block">ไม่เกิน 255 ตัวอักษร</p>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('เนื้อหาแบบย่อ', 'news_short_detail', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::textarea('news_short_detail', Input::post('news_short_detail', isset($news) ? $news->news_short_detail : ''), array('class' => 'form-control', 'rows' => 8, 'placeholder' => 'ระบุเนื้อหาแบบย่อ')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('เนื้อหา', 'news_detail', array('class' => 'control-label tinymce')); ?>
            <div class="controls form-group">
                <?php echo Form::textarea('news_detail', Input::post('news_detail', isset($news) ? $news->news_detail : ''), array('class' => 'form-control htmltextarea', 'rows' => 20, 'placeholder' => 'ระบุเนื้อหา')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('ไฟล์ภาพประกอบข่าว', 'news_photo', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <span class="btn btn-default fileinput-button">
                    <i class="fa fa-plus"></i>
                    <span id="photo-file-name">เลือกไฟล์ภาพ</span>
                    <input id="photo-file" type="file" name="news_photo_file" accept="image/*" />
                </span>
                <p class="help-block">รองรับไฟล์ .jpg และ .png</p>
            </div>
            <div class="controls form-group">
                <div>
                    <img id="photo-preview" src="<?php echo (isset($news) && strlen($news->news_photo))?"http://www.buffohero.com/uploads/news_photo/".$news->news_photo:"http://placehold.it/640x480/fff.png"; ?>" border="0" style="width:50%;" />
                </div>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('สถานะ', 'news_published', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <div class="btn-group" data-toggle="buttons">
                    <label id="active_1" class="btn btn-<?php echo (isset($news)&&$news->news_published==1)?"primary":"default"; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input type="radio" name="news_published" value="1" <?php if(isset($news) && $news->news_published == 1){ ?>checked="checked" <?php } ?>> เผยแพร่
                    </label>
                    <label id="active_0" class="btn btn-<?php echo (!isset($news) || isset($news)&&$news->news_published==0)?"danger":"default"; ?>" data-toggle-class="btn-danger" data-toggle-passive-class="btn-default">
                        <input type="radio" name="news_published" value="0" <?php if(!isset($news) || isset($news)&&$news->news_published==0){ ?>checked="checked" <?php } ?>> ระงับ
                    </label>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <a class="btn btn-success" href="javascript:void(0);" onclick="$('#form-news').submit();">Save</a>
            <a class="btn btn-default" href="<?php echo Uri::create('news'); ?>">Cancel</a>
        </div>
    <?php echo Form::fieldset_close(); ?></fieldset>
    <?php echo Form::close(); ?>
</div>