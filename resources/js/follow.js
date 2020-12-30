$(document).on("click", ".btn-follow", function(){
    let id = $(this).data('id');
    let countFollower = $(".span-follower").data("countfollower");
    var token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url : '/follow',
        type: 'post',
        data : {
            'id' : id,
            'token' : token,
        },
        headers : {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success : function(result){
            html = `<button type="button" class="btn profile-edit-btn btn-unfollow" data-token="{{ csrf_token() }}" id="btn-unfollow${ result.follow_id }" data-id=${ result.follow_id }>Unfollow</button> `;
            $(".btn-follow").replaceWith(html);
            $(".span-follower").text(countFollower + 1);
        },
        error : function(result){
            alert("Not Working!");
        }
    });
});

$(document).on("click", ".btn-unfollow", function(){
    let id = $(this).data("id");
    let countFollower = $(".span-follower").data("countfollower");
    var token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url : '/unfollow/' + id,
        type : 'delete',
        data : {
            'id' : id,
            'token' : token,
        },
        headers : {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success : function(result){
            html = `<button type="button" class="btn profile-edit-btn btn-follow" data-token="{{ csrf_token() }}" id="btn-follow${ result.follow_id }" data-id=${ result.follow_id }>Follow</button> `;
            $(".btn-unfollow").replaceWith(html);
            $(".span-follower").text(countFollower);
        },
        error : function(result){
            alert("Not Working!");
        }
    });
})
