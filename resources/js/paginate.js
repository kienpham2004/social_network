$(document).on('click', '.btn-loadmore', function(){
    let id = $(this).attr('value');
    let token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url : '/home/load-post',
        type : 'post',
        data : {
            '_token' : token,
            'id' : id,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success : function(result){
            if (result != '') {
                $('.btn-loadmore').remove();
                $('#loadPost').append(result);
            } else {
                $('.btn-loadmore').html('End post');
            }
        },
    });
});

$(document).on('click', '.view_comment', function(){
    let id = $(this).data('post-id');
    let token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url : '/home/view-comment',
        type : 'post',
        data : {
            '_token' : token,
            'id' : id,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success : function(result){
            $('.view_comment' + id).remove();
            $('#listComment' + id).append(result);
        },
    });
});
