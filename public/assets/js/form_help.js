function expand(){
    $('#right').hide();
    $('#left').removeClass('col-md-8');
    $('#left').addClass('col-md-12');
    $('#btn-expand').hide();
    $('#btn-compress').show();
}

function compress(){
    $('#right').show();
    $('#left').removeClass('col-md-12');
    $('#left').addClass('col-md-8');
    $('#btn-expand').show();
    $('#btn-compress').hide();
}

function beforeDelete(id){

    var conf = confirm("ต้องการลบรูปภาพนี้?");
    if(!conf) return false;

    $('#delete-photo-id').val(id);

    $('#delete-photo-form').submit();

}

$(document).ready(function(){

    $('#photo-file-1').change(function(e){
        var value = $('#photo-file-1').val();
        $('#photo-file-name-1').text(value.substr(value.lastIndexOf("\\")+1));
    });

    $('#photo-file-2').change(function(e){
        var value = $('#photo-file-2').val();
        $('#photo-file-name-2').text(value.substr(value.lastIndexOf("\\")+1));
    });

    $('#photo-file-3').change(function(e){
        var value = $('#photo-file-3').val();
        $('#photo-file-name-3').text(value.substr(value.lastIndexOf("\\")+1));
    });

    $('#photo-file-4').change(function(e){
        var value = $('#photo-file-4').val();
        $('#photo-file-name-4').text(value.substr(value.lastIndexOf("\\")+1));
    });

    $('#photo-file-5').change(function(e){
        var value = $('#photo-file-5').val();
        $('#photo-file-name-5').text(value.substr(value.lastIndexOf("\\")+1));
    });


});