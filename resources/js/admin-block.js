$(document).on("click", ".active", function(){
    let id = $(this).data("id");
    let status = 0;
    var token = $('meta[name="csrf-token"]').attr('content');     
    $.ajax({
        url : 'edit-status/disabled/' + id,
        type : 'patch',
        data : {
            'id' : id,
            'token' : token,
            'status' : status,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (result){
            html = `<button data-token="{{ csrf_token() }}" class="disabled" id="disabled${ result.id }" data-id=${ result.id } ><i class="fas fa-bell-slash"></i></button>`;
            $("#active" + id).replaceWith(html);
            $("#status" + id).text(0);
        },
        error: function (result){
            alert('Not working');
        },
    });
});

$(document).on("click", ".disabled", function(){
    let id = $(this).data("id");
    let status = 1;
    var token = $('meta[name="csrf-token"]').attr('content');     
    $.ajax({
        url : 'edit-status/disabled/' + id,
        type : 'patch',
        data : {
            'id' : id,
            'token' : token,
            'status' : status,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (result){
            html = `<button data-token="{{ csrf_token() }}" class="active" id="active${ result.id }" data-id=${ result.id } ><i class="fas fa-bell"></i></button>`;
            $("#disabled" + id).replaceWith(html);
            $("#status" + id).text(1);
        },
        error: function (result){
            alert('Not working');
        },
    });
});
