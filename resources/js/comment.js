$(document).on("click", ".send-comment-on-post", function(){
    let postId= $(this).data('post-id');
    $("#commentValue" + postId).text('');
    let valueComment = $("#commentValue"+postId).val();
    var token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type : 'post',
        url : '/home/comment/add',
        data : {
            '_token' : token,
            'valueComment' : valueComment,
            'postId' : postId,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (result){
            $("#listComment" + postId).append(result);
            toastr.success('Add comment complete.', 'Success');
            toastr.options.timeOut = 3000;
            $("#commentValue" + postId).val("");
        },
        error : function(result) {
            if (result.status == 422) {
                let error = result.responseJSON;
                $("#show-errors" + postId).text(error.errors.valueComment).css("color", "red");
            }
        }
    })
})

$(document).on("click", ".deleteComment", function(){
    let id = $(this).data("id");
    var token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url : '/comment/delete/' + id,
        type : 'DELETE',
        data : {
            'id' : id,
            '_token' : token,
        },
        headers : {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success : function(){
            $(".item-comment"+ id).remove();
            toastr.error('Delete comment complete.', 'Delete');
            toastr.options.timeOut = 3000;
            $(".input-post").html("");
        },
        error : function(){	
            alert('Not working!');	
        }
    });
});

$(document).on("click", ".editComment", function(){
    let id = $(this).data("id");
    $(".formEditComment"+ id).slideToggle("slow");
});

$(document).on("click", ".submitEditComment", function(){
    let id = $(this).attr("value");
    let valueEditComment = $("#edit" + id).val();
    var token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url : '/comment/edit/' + id,
        type : 'patch',
        data : {
            'id' : id,
            '_token' : token,
            'valueEditComment' : valueEditComment,
        },
        headers : {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success : function(result){
            $(".item-comment" + id).html(result);
            toastr.warning('Edit comment success', 'Edit comment');
            toastr.options.timeOut = 3000;
        },
        error : function(){	
            alert('Not working!');	
        }
    });
});

$(document).on('keyup', '.add_comment', function(){
    let id = $(this).data('id');
    $('.send-comment').prop('disabled', true);
    if ($(this).val() != '') {
        $('.send-comment' + id).prop('disabled', false);
    } else {
        $('.send-comment' + id).prop('disabled', true);
    }
})
