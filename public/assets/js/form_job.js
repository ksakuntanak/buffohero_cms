$(document).ready(function(){

    $('#cat_id').change(function(){

        var cat_id = $('#cat_id').val();
        var subcat = subcats[cat_id];

        var subcat_id = $('#subcat_id');

        subcat_id.empty();
        subcat_id.append('<option value=""></option>');

        $('#s2id_subcat_id > a > span').text("ระบุหมวดหมู่ย่อย");

        for(var id in subcat){
            var option = $('<option value="' + id + '">' + subcat[id] + '</option>');
            subcat_id.append(option);
        }

        subcat_id.val("");

    });

    $('#type-fulltime').click(function(){

        $('#job-title-fulltime').show();
        $('#job-title-project').hide();
        $('#job-title-contest').hide();

        /* common */
        $('#job-cat-id').show();
        $('#job-subcat-id').show();
        $('#job-desc').show();
        $('#job-qualifications').show();
        $('#job-skills').show();
        $('#job-attachment').show();
        $('#job-is-featured').show();
        $('#job-is-urgent').show();
        $('#job-is-active').show();

        /* fulltime */
        $('#job-position').show();
        $('#job-areas').show();
        $('#job-salary').show();
        $('#job-welfare').show();

        /* project */
        $('#job-budget').hide();

        /* contest */
        $('#job-prize').hide();

    });

    $('#type-project').click(function(){

        $('#job-title-fulltime').hide();
        $('#job-title-project').show();
        $('#job-title-contest').hide();

        /* common */
        $('#job-cat-id').show();
        $('#job-subcat-id').show();
        $('#job-desc').show();
        $('#job-qualifications').hide();
        $('#job-skills').show();
        $('#job-attachment').show();
        $('#job-is-featured').show();
        $('#job-is-urgent').show();
        $('#job-is-active').show();

        /* fulltime */
        $('#job-position').hide();
        $('#job-areas').hide();
        $('#job-salary').hide();
        $('#job-welfare').hide();

        /* project */
        $('#job-budget').show();

        /* contest */
        $('#job-prize').hide();

    });

    $('#type-contest').click(function(){

        $('#job-title-fulltime').hide();
        $('#job-title-project').hide();
        $('#job-title-contest').show();

        /* common */
        $('#job-cat-id').show();
        $('#job-subcat-id').show();
        $('#job-desc').show();
        $('#job-qualifications').hide();
        $('#job-skills').show();
        $('#job-attachment').show();
        $('#job-is-featured').show();
        $('#job-is-urgent').show();
        $('#job-is-active').show();

        /* fulltime */
        $('#job-position').hide();
        $('#job-areas').hide();
        $('#job-salary').hide();
        $('#job-welfare').hide();

        /* project */
        $('#job-budget').hide();

        /* contest */
        $('#job-prize').show();

    });

    $('#photo-file').change(function(e){

        var value = $('#photo-file').val();

        $('#photo-file-name').text(value.substr(value.lastIndexOf("\\")+1));

        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var image = e.target.result;
                $('#photo-preview').attr('src',image);
            }
            reader.readAsDataURL(this.files[0]);
        }

    });

    $('#job-attachment-file').change(function(e){

        var value = $('#job-attachment-file').val();

        $('#job-attachment-file-name').text(value.substr(value.lastIndexOf("\\")+1));

    });

});