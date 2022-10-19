function triggerClick(){
    document.querySelector('#image').click();
}


function displayImage(image_form){
    if(image_form.files[0]) {
        var reader = new FileReader();

        reader.onload = function(image_form) {
            document.querySelector("#image_display").setAttribute('src', image_form.target.result);
        }
        reader.readAsDataURL(image_form.files[0]);
    }
}

