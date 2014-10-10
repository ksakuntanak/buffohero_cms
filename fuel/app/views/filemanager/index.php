<div class="col-lg-12">
    <div class="row">
        <div class="widget">
            <?php echo \Fuel\Core\Html::anchor('filemanager/create/dir/','Create Dir',array('class'=>'btn btn-primary','id'=>'dir_form'))?>
            <div id="create_dir" style="display: none">
                <form class="form form-horizontal" action="<?php echo \Fuel\Core\Uri::create('filemanager/create/dir/')?>" method="POST">
                    <div class="form-group">
                        <label class="col-lg-2 control-label">
                            Name :
                        </label>
                        <div class="col-lg-8">
                            <input type="text" name="dir_name" class="form-control col-lg-6" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">

                        </label>
                        <div class="col-lg-8">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <button type="button" name="cancel" class="btn btn-default" id="cancel">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
            <hr />
            <table class="table">
                <?php
                foreach ($all_folder as $k=>$v):
                    if(!is_int($k)):
                    ?>
                    <tr>
                        <td>
                            <?php echo \Fuel\Core\Html::anchor(\Fuel\Core\Uri::string().'/folder/'.$k,$k)?>
                        </td>
                    </tr>
                <?php endif;endforeach; ?>
            </table>
        </div>
    </div>
</div>
<script src="https://buffohero.com/cms/public/assets/lib/jquery/jquery-2.0.3.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#dir_form').click(function(){
            $('#create_dir').show();
            return false;
        })

        $('#cancel').click(function(){
            $('#create_dir').hide();
        })
    })
</script>
