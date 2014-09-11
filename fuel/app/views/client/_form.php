<header>
    <h4><i class="fa fa-bars"></i> ข้อมูลลูกค้า</h4>
    <!--div class="actions">
        <button id="btn-expand" class="btn btn-xs btn-primary" onclick="expand();"><i class="fa fa-expand"></i> ขยายกรอบนี้</button>
        <button id="btn-compress" class="btn btn-xs btn-primary" style="display:none;" onclick="compress();"><i class="fa fa-compress"></i> ย่อกรอบนี้</button>
    </div-->
</header>
<div class="body">
    <?php echo Form::open(array("id" => "form-client", "class" => "form-horizontal", "enctype" => "multipart/form-data")); ?>
    <?php echo Form::fieldset_open(); ?>
        <input type="hidden" name="action" value="edit_client" />
        <div class="form-group">
            <?php echo Form::label('ชื่อลูกค้า <span class="required">*</span>', 'client_title', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('client_title', Input::post('client_title', isset($client) ? $client->client_title : ''), array('class' => 'form-control', 'placeholder' => 'ระบุชื่อลูกค้า')); ?>
                <p class="help-block">ไม่เกิน 255 ตัวอักษร</p>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('URL <span class="required">*</span>', 'client_url', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <?php echo Form::input('client_url', Input::post('client_url', isset($client) ? $client->client_url : ''), array('class' => 'form-control', 'placeholder' => 'ระบุ URL')); ?>
                <p class="help-block">ไม่เกิน 255 ตัวอักษร</p>
            </div>
        </div>
        <div class="form-group">
            <?php echo Form::label('ไฟล์ภาพ Logo', 'client_photo', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <span class="btn btn-default fileinput-button">
                    <i class="fa fa-plus"></i>
                    <span id="client-photo-file-name">เลือกไฟล์ภาพ</span>
                    <input id="client-photo-file" type="file" name="client_photo_file" accept="image/*" />
                </span>
                <p class="help-block">รองรับไฟล์ .jpg และ .png ขนาด 330 x 128 pixel</p>
            </div>
            <div class="controls form-group">
                <div style="width:165px;height:64px;overflow:hidden;">
                    <img id="client-photo-preview" style="width:165px;" src="<?php echo (isset($client) && strlen($client->client_photo))?"http://www.buffohero.com/uploads/client_photo/".$client->client_photo:"http://placehold.it/165x64/fff.png"; ?>" border="0" />
                </div>
            </div>
        </div>
        <?php if(isset($client)) { ?>
        <div class="form-group">
            <?php echo Form::label('สถานะ', 'client_active', array('class' => 'control-label')); ?>
            <div class="controls form-group">
                <div class="btn-group" data-toggle="buttons">
                    <label id="active_1" class="btn btn-<?php echo (isset($client)&&$client->client_active==1)?"primary":"default"; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input type="radio" name="client_active" value="1" <?php if(isset($client) && $client->client_active == 1){ ?>checked="checked" <?php } ?>> ปกติ
                    </label>
                    <label id="active_0" class="btn btn-<?php echo (!isset($client) || isset($client)&&$client->client_active==0)?"danger":"default"; ?>" data-toggle-class="btn-danger" data-toggle-passive-class="btn-default">
                        <input type="radio" name="client_active" value="0" <?php if(!isset($client) || isset($client)&&$client->client_active==0){ ?>checked="checked" <?php } ?>> ระงับ
                    </label>
                </div>
            </div>
        </div>
        <?php } ?>
        <div class="form-actions">
            <a class="btn btn-success" href="javascript:void(0);" onclick="$('#form-client').submit();">Save</a>
            <a class="btn btn-default" href="<?php echo Uri::create('client'); ?>">Cancel</a>
        </div>
    <?php echo Form::fieldset_close(); ?></fieldset>
    <?php echo Form::close(); ?>
</div>