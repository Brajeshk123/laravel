document.addEventListener("DOMContentLoaded", function () {

    let image = document.querySelector("[name='profile_image']");

    if(image){

        image.addEventListener("change", function(){

            console.log("Image Selected");

        });

    }

});