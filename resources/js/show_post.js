$(document).ready(function(){
    $(".buttonComment").click(function(){
        $(".comment-box").slideToggle("slow");
    });
});

$(document).ready(function(){
    $("#btn-edit-post").click(function(){
        $("#edit-content-post").slideToggle("slow");
    });
}); 

$(document).on("click", ".send-comment-on-post", function(){
    let postId= $(this).data('post-id');
    $("#commentValue" + postId).text('');
    let valueComment = $("#commentValue"+postId).val();
    var token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type : "post",
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
        }
    });
});


$(document).ready(function() {
    $('.send-comment-on-post').prop('disabled', true);
    $('.add_comment').keyup(function() {
       if($(this).val() != '') {
          $('.send-comment-on-post').prop('disabled', false);
          $('.send-comment-on-post').css('background-color', 'transparent');
          $('.send-comment-on-post').css('color', '#24a0f7');
       }else{
           $('.send-comment-on-post').prop('disabled', true);
           $('.send-comment-on-post').css('background-color', 'transparent');
           $('.send-comment-on-post').css('color', 'gray');
       }
    });
});

$(document).on('click', '.button-like' , function(){
    let idPost = $(this).data("id");
    let token = $('meta[name="csrf-token"]').attr('content');
    let countLike = parseInt($(this).data('count'));
    $.ajax({
        url : "/like/post",
        type : "post",
        data : {
            '_token' : token,
            'id' : idPost,
            'countLike' : parseInt(countLike),
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success : function(result){
            html = `<button class="btn p-0 button-unlike" data-count=${parseInt(result.countLike) + 1} data-token="{{ csrf_token() }}" id="unlike${result.post_id}" data-id="${result.post_id}">
                        <svg width="1.6em" height="1.6em" viewBox="0 0 16 16"
                            class="fas fa-heart" fill="currentColor"
                            style="font-size: 23px; color: #ed4956">
                            <path fill-rule="evenodd"
                                d="M8 2.748l-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z" />
                        </svg>
                    </button>`;
            $("#like" + idPost).replaceWith(html);
            $(".count-like" + idPost).text(countLike + 1);
        },
        error : function(result){
            alert('not working!!');
        }
    });
});

$(document).on('click', '.button-unlike' , function(){
    let idPost = $(this).data("id");
    let token = $('meta[name="csrf-token"]').attr('content');
    let countLike = $(this).data('count');
    $.ajax({
        url : "/unlike/post/" + idPost,
        type : "delete",
        data : {
            'id' : idPost,
            '_token' : token,
            'countLike' : countLike,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success : function(result){
            html = `<button class="btn p-0 button-like" data-count="${parseInt(result.countLike) - 1}" data-token="{{ csrf_token() }}" id="like${result.post_id}" data-id="${result.post_id}">
                        <svg width="1.6em" height="1.6em" viewBox="0 0 16 16"
                            class="far fa-heart icon-like" fill="currentColor"
                            style="font-size: 23px">
                            <path fill-rule="evenodd"
                                d="M8 2.748l-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z" />
                        </svg>
                    </button>`;
            $("#unlike" + idPost).replaceWith(html);
            $(".count-like" + idPost).text(countLike - 1);
        },
        error : function(result){
            alert('not working!!');
        }
    });
});

    $(document).on("click", ".send-comment", function(){
    let postId= $(this).data('post-id');
    $("#commentValue" + postId).text('');
    let valueComment = $("#commentValue"+postId).val();
    var token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type : "post",
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
                console.log(error);
            }
        }
    })
})

$(document).on("click", ".deleteComment", function(){
    let id = $(this).data("id");
    var token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url : "/comment/delete/" + id,
        type : "DELETE",
        data : {
            "id" : id,
            "_token" : token,
        },
        headers : {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success : function(){
            $(".item-comment"+ id).remove();
            toastr.error('Delete comment complete.', 'Delete');
            toastr.options.timeOut = 3000;
            $(".input-post").html("");
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
        url : "/comment/edit/" + id,
        type : "patch",
        data : {
            "id" : id,
            "_token" : token,
            "valueEditComment" : valueEditComment,
        },
        headers : {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success : function(result){
            $(".item-comment" + id).html(result);
            toastr.warning('Edit comment success', 'Edit comment');
            toastr.options.timeOut = 3000;
        }
    });
});

$(document).ready(function() {
    $('.send-comment').prop('disabled', true);
    $('.add_comment').keyup(function() {
       if($(this).val() != '') {
          $('.send-comment').prop('disabled', false);
       }else{
           $('.send-comment').prop('disabled', true);
       }
    });
});
