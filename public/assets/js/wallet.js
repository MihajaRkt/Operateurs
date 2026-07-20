document.addEventListener('DOMContentLoaded', function () {

    const btn = document.getElementById("btn-toggle");
    btn.addEventListener("click", afficherForm);

});

function afficherForm(e){
    const div= document.getElementById("code");
    div.classList.toggle("active");
}