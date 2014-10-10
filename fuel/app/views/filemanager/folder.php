<div class="col-lg-12">
    <div class="row">
        <div class="page-header">
            <h3><?php echo \Fuel\Core\Inflector::humanize($folder) ?></h3>
            <button class="btn btn-primary" id="up"><i class="fa fa-plus"></i> เพิ่มรูป</button>
            <hr />
        </div>
        <div class="widget" id="upload">
            <?php if (\Fuel\Core\Session::get_flash('error')): ?>
                <div class="alert alert-danger">
                    <?php echo \Fuel\Core\Session::get_flash('error') ?>
                </div>
            <?php endif; ?>
            <form class="form form-horizontal"
                  role="form" enctype="multipart/form-data"
                  action="<?php echo \Fuel\Core\Uri::create('filemanager/upload/' . $folder) ?>"
                  method="POST" >
                <div class="form-group" style="display: none" id="preview">
                    <label class="control-label col-lg-2">

                    </label>

                    <div class="col-lg-10" id="img_preview">

                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-2">
                        Upload :
                    </label>

                    <div class="col-lg-10">
                        <input type="file" name="image" id="fileupload"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-2">
                        Name :
                    </label>

                    <div class="col-lg-4">
                        <input type="text" name="key" class="form-control" id="key"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-2">
                        Photographer :
                    </label>

                    <div class="col-lg-4">
                        <input type="text" name="photographer" class="form-control" id="photographer"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-2">
                        Price :
                    </label>

                    <div class="col-lg-4">
                        <input type="text" name="price" class="form-control" id="price"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-2">
                        Usage :
                    </label>

                    <div class="col-lg-4">
                        <select name="usage" class="form-control" id="usage">
                            <option value="normal">Normal</option>
                            <option value="special">Special</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-2">
                        Source :
                    </label>

                    <div class="col-lg-4">
                        <input type="text" name="source" placeholder="url to source" class="form-control" id="source"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-2">

                    </label>
                    <div class="col-lg-10">
                        <input type="hidden" name="id" id="id" value="" />
                        <button type="button" id="cancel" class="btn btn-default">
                             Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-upload"></i> Send
                        </button>

                    </div>
                </div>
            </form>
            <div class="clearfix"></div>
        </div>
        <div id="wall">
            <?php
            try{
                foreach ($all as $k => $v):
                    if (is_int($k)) {
                        $name = '';
                        $model = Model_Filemanager::find_by_value($v);
                        if ($model and $model->deleted_at==null) {
                            $name = $model->key;
                            $v = str_replace('150x150_', '', $v);
                            echo '<div class=" col-lg-2"><div class="thumbnail">';
                            echo \Fuel\Core\Html::img('images/file/' . $folder . '/270x270/crop/?image=' . $v);
                            echo '<div class="caption">';
                            echo '<p class="img_name">' . $name . '</p>';
                            echo '<p>' . \Fuel\Core\Html::anchor('images/file/' . $folder . '/150x150/crop/?image=' . $v . '&action=view',
                                    '<i class="fa fa-eye-open"></i> ดูข้อมูล',
                                    array('class' => 'btn btn-info view')
                                ) . '</p>';
                            echo '<p>' . \Fuel\Core\Html::anchor('images/file/' . $folder . '/150x150/crop/?image=' . $v . '&action=delete',
                                    '<i class="fa fa-times"></i> ลบ',
                                    array('class' => 'btn btn-danger')
                                ) . '</p>';
                            echo '</div>';
                            echo '</div></div> ';
                        }

                    }
                endforeach;
            }catch(Exception $e){
                echo $e->getMessage();

            }

             ?>

            <div class="clearfix"></div>
        </div>
    </div>
</div>

<script>

    $('#fileupload').change(function(){
        $('#key').val($(this).val());
    })

    $('#upload').hide();

    $('#up').click(function(){
        $('#img_preview').html('');
        $('#id').val('');
        $('#key').val('');
        $('#photographer').val('');
        $('#price').val('');
        $('#usage').val('normal');
        $('#source').val('');
        $('#upload').toggle();
        $('#wall').toggle()
    })

    $('#cancel').click(function(){
        $('#up').trigger('click')
    })

    $('.view').click(function(){
        var img_name = $(this).parent().parent().find('p.img_name').text();
        var img = '<img src="'+$(this).attr('href')+'"/>';

        $.get('<?php echo \Fuel\Core\Uri::create('services/images/image.json?image=')?>'+img_name,function(callback){
            if(callback.result==true){
                $('#img_preview').html(img);
                $('#id').val(callback.data.id);
                $('#key').val(callback.data.key);
                $('#photographer').val(callback.data.photographer);
                $('#price').val(callback.data.price);
                $('#usage').val(callback.data.usage);
                $('#source').val(callback.data.source);
            }
        })

        $('#preview').show()
        $('#up').trigger('click')
        return false;
    })
</script>