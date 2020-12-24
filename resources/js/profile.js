function uploadimg(input, imgPreviewPlaceholder) {
    if (input.files) {
        var filesAmount = input.files.length;
        for (i = 0; i < filesAmount; i++) {
            var reader = new FileReader();
            reader.onload = function(event) {
                $($.parseHTML('<img>')).attr('src', event.target.result).attr('class', "imgupload").appendTo(imgPreviewPlaceholder);
            }
            reader.readAsDataURL(input.files[i]);
        }
    }
};

$(document).on("change", "#exampleFormControlFile1", function(){
    $(".imgPreview").html(' ');
    uploadimg(this, 'div.imgPreview');
});
