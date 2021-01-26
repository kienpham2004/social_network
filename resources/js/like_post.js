$(document).on('click', '.button-like' , function(){
    let idPost = $(this).data("id");
    let token = $('meta[name="csrf-token"]').attr('content');
    let countLike = $(this).data('count');
    let user_id = $(this).data('user-id');
    $.ajax({
        url : "/like/post",
        type : "post",
        data : {
            '_token' : token,
            'id' : idPost,
            'user_id' : user_id,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success : function(result){
            html = `<button class="btn p-0 button-unlike" data-user-id="${ result.id_user_noti }" data-token="{{ csrf_token() }}" id="unlike${ result.post_id }" data-id="${ result.post_id }">
                        <svg class="icon" viewBox="0 0 16 16"
                            class="fas fa-heart" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8 2.748l-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z" />
                        </svg>
                    </button>`;

            $("#like" + idPost).replaceWith(html);
            $(".count-like" + idPost).text(countLike + 1);
        },
        error : function(result){
            alert("Not Working!");
        }
    });
});

$(document).on('click', '.button-unlike' , function(){
    let idPost = $(this).data("id");
    let token = $('meta[name="csrf-token"]').attr('content');
    let countLike = $(this).data('count');
    let user_id = $(this).data('user-id');
    $.ajax({
        url : "/unlike/post/" + idPost,
        type : "delete",
        data : {
            'id' : idPost,
            '_token' : token,
            'user_id' : user_id,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success : function(result){
            html = `<button class="btn p-0 button-like" data-user-id="${ result.id_user_noti }" data-token="{{ csrf_token() }}" id="like${result.post_id}" data-id="${result.post_id}">
                        <svg class="icon" viewBox="0 0 16 16"
                            class="far fa-heart icon-like" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8 2.748l-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z" />
                        </svg>
                    </button>`;
            $("#unlike" + idPost).replaceWith(html);
            $(".count-like" + idPost).text(countLike - 1);
        },
        error : function(result){
            alert("Not Working!");
        }
    });
});
