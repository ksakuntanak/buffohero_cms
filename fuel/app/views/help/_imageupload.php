<?php if(isset($help)) { ?>
<section class="widget">
    <header>
        <h4><i class="fa fa-upload"></i> อัพโหลดไฟล์ภาพประกอบเนื้อหาหัวข้อช่วยเหลือ</h4>
    </header>
    <div class="body">
        <p>ผู้ใช้งานต้องอัพโหลดไฟล์ภาพที่ต้องการขึ้นสู่ระบบก่อน จึงจะสามารถนำภาพไปแทรกในเนื้อหาได้</p>
        <p class="help-block">* รองรับไฟล์ .jpg หรือ .png เท่านั้น</p>
        <form id="photo_upload" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="upload_photos" />
            <input type="hidden" name="help_id" value="<?php echo $help->id; ?>" />
            <div class="form-group">
                <span class="btn btn-default fileinput-button" style="float:none;">
                    <i class="fa fa-plus"></i>
                    <span id="photo-file-name-1">เลือกไฟล์ภาพ</span>
                    <input id="photo-file-1" type="file" name="help_photo_file[]" accept="image/*" />
                </span>
            </div>
            <div class="form-group">
                <span class="btn btn-default fileinput-button" style="float:none;">
                    <i class="fa fa-plus"></i>
                    <span id="photo-file-name-2">เลือกไฟล์ภาพ</span>
                    <input id="photo-file-2" type="file" name="help_photo_file[]" accept="image/*" />
                </span>
            </div>
            <div class="form-group">
                <span class="btn btn-default fileinput-button" style="float:none;">
                    <i class="fa fa-plus"></i>
                    <span id="photo-file-name-3">เลือกไฟล์ภาพ</span>
                    <input id="photo-file-3" type="file" name="help_photo_file[]" accept="image/*" />
                </span>
            </div>
            <div class="form-group">
                <span class="btn btn-default fileinput-button" style="float:none;">
                    <i class="fa fa-plus"></i>
                    <span id="photo-file-name-4">เลือกไฟล์ภาพ</span>
                    <input id="photo-file-4" type="file" name="help_photo_file[]" accept="image/*" />
                </span>
            </div>
            <div class="form-group">
                <span class="btn btn-default fileinput-button" style="float:none;">
                    <i class="fa fa-plus"></i>
                    <span id="photo-file-name-5">เลือกไฟล์ภาพ</span>
                    <input id="photo-file-5" type="file" name="help_photo_file[]" accept="image/*" />
                </span>
            </div>
            <div class="form-actions">
                <div class="">
                    <button type="submit" class="btn btn-success"><i class="fa fa-upload"></i> Upload</button>
                </div>
            </div>
        </form>
    </div>
</section>
<section class="widget">
    <header>
        <h4><i class="fa fa-picture-o"></i> ไฟล์ภาพประกอบเนื้อหาบล็อกที่มีอยู่</h4>
    </header>
    <div class="body">
        <p>ลากรูปภาพไปวางในช่องกรอกเนื้อหาเพื่อแทรกภาพ หรือคลิกที่ภาพเพื่อแสดง URL ของภาพ แล้วนำ URL ไปกรอกในช่องแทรกภาพ</p>
        <div class="form-group">
            <input type="text" class="form-control" id="photo-url" value="" />
        </div>
        <?php if(count($photos)) { ?>
            <?php for($i = 0; $i < count($photos); $i++) { ?>
            <?php if($i%2 == 0) { ?><ul id="photo-list" class="row thumbnails"><?php } ?>
                <li class="col-sm-6">
                    <div style="text-align:center;">
                        <a class="thumbnail" href="javascript:void(0);" onclick="$('#photo-url').val('<?php echo $path.$photos[$i]['photo_file_name']; ?>');">
                            <img src="<?php echo $path.$photos[$i]['photo_file_name']; ?>" />
                        </a>
                        <a class="btn btn-danger" href="javascript:void(0);" onclick="beforeDelete(<?php echo $photos[$i]['id']; ?>);">Delete</a>
                    </div>
                </li>
            <?php if(($i+1)%2 == 0) { ?></ul><?php } ?>
            <?php } ?>
        <?php } ?>
    </div>
    <form id="delete-photo-form" action="" method="post">
        <input type="hidden" name="action" value="delete_photo" />
        <input type="hidden" id="delete-photo-id" name="photo_id" value="" />
    </form>
</section>
<?php } ?>