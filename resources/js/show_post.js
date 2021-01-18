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
