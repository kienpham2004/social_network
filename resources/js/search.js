$(document).on("keyup", ".search-input", function () {
    var getValueSearch = $(this).val();
    $.ajax({
        type : "POST",
        url : '/search',
        data : {
            "valueSearch" : getValueSearch,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (result) {
            $("#result").html(result);
        },
        error : function(result){
            alert("Not Working!");
        } 
    }); 
})
