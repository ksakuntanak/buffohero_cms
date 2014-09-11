$(document).ready(function(){

    $('#client-photo-file').change(function(e){

        var value = $('#client-photo-file').val();

        $('#client-photo-file-name').text(value.substr(value.lastIndexOf("\\")+1));

        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var image = e.target.result;
                $('#client-photo-preview').attr('src',image);
            }
            reader.readAsDataURL(this.files[0]);
        }

    });

});