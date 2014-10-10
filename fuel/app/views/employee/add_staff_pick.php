<?php try { ?>
<?php $error = Session::get_flash('error'); ?>
<?php if(strlen($error)) { ?>
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <p><?php echo $error; ?></p>
    </div>
<?php } ?>
<section class="widget">
    <?php echo render('employee/_form_staffpick'); ?>
</section>
<script type="text/javascript">

    $('#pick-photo-file').change(function(e){

        var value = $('#pick-photo-file').val();

        $('#pick-photo-file-name').text(value.substr(value.lastIndexOf("\\")+1));

        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var image = e.target.result;
                $('#pick-photo-preview').attr('src',image);
            }
            reader.readAsDataURL(this.files[0]);
        }

    });

    $('#btn-add-skill').click(function(){

        $('.skill-level').unbind('change');
        $('.skill-level-plus').unbind('click');
        $('.skill-level-minus').unbind('click');
        $('.skill-delete').unbind('click');

        var node = '<div class="row">' +
            '<div class="col-lg-4">' +
                '<input type="text" class="form-control skill-title" name="skill_title[]" maxlength="255" placeholder="กรอกชื่อทักษะ" value="" />' +
            '</div>' +
            '<div class="col-lg-2">' +
                '<div class="input-group">' +
                    '<input type="text" class="form-control skill-level" name="skill_level[]" placeholder="กรอกตัวเลข 0 - 100" value="">' +
                    '<div class="input-group-btn">' +
                        '<button type="button" class="btn btn-default skill-level-plus"><i class="fa fa-plus"></i></button>' +
                        '<button type="button" class="btn btn-default skill-level-minus"><i class="fa fa-minus"></i></button>' +
                    '</div>' +
                '</div>' +
            '</div>' +
            '<div class="col-lg-6">' +
                '<button type="button" class="btn btn-danger skill-delete"><i class="fa fa-times"></i> เอาออก</button>' +
            '</div>' +
        '</div>' +
        '<p class="fc-header-space"></p>';

        $('#skills').append($(node));

        $('.skill-level').change(function(){
            if(isNaN($(this).val()) || $(this).val() == '') $(this).val(0);
        });

        $('.skill-level-plus').click(function(){

            var node = $(this).parent().parent();
            var text = node.find('input[type=text]');
            var level = text.val();

            if(isNaN(level)) level = 0;

            level++;

            if(level > 100) level = 100;

            text.val(level);

        });

        $('.skill-level-minus').click(function(){

            var node = $(this).parent().parent();
            var text = node.find('input[type=text]');
            var level = text.val();

            if(isNaN(level)) level = 0;

            level--;

            if(level < 0) level = 0;

            text.val(level);

        });

        $('.skill-delete').click(function(){

            var node = $(this).parent().parent().parent().parent();
            node.remove();

        });

    });

    $('.skill-level').change(function(){
        if(isNaN($(this).val()) || $(this).val() == '') $(this).val(0);
    });

    $('.skill-level-plus').click(function(){

        var node = $(this).parent().parent();
        var text = node.find('input[type=text]');
        var level = text.val();

        if(isNaN(level)) level = 0;

        level++;

        if(level > 100) level = 100;

        text.val(level);

    });

    $('.skill-level-minus').click(function(){

        var node = $(this).parent().parent();
        var text = node.find('input[type=text]');
        var level = text.val();

        if(isNaN(level)) level = 0;

        level--;

        if(level < 0) level = 0;

        text.val(level);

    });

    $('.skill-delete').click(function(){

        var node = $(this).parent().parent().parent().parent();
        node.remove();

    });

</script>
<?php } catch(Exception $e){
    echo $e->getMessage();
} ?>