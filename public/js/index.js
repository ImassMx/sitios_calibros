document.addEventListener('DOMContentLoaded', () => {
    hamburguer();
    efectoMenu();
    scrollNava();
})


function hamburguer() {

    const nav = document.querySelector('#hamburguer');
    nav.addEventListener('click', e => {

        nav.classList.toggle('open')
    })

}

function efectoMenu() {
    const hamburguesa = document.querySelector("#hamburguer");

    const navegacion = document.querySelector(".menu_items");
    hamburguesa.addEventListener("click", () => {

        navegacion.classList.toggle("show");
      

    });
}


/* function scrollNava(){
    document.querySelectorAll(".menu_items li").forEach((function(e){e.addEventListener("click",(function(e){e.preventDefault();
    document.querySelector(e.target.attributes.href.value).scrollIntoView({behavior:"smooth"})}))}))} */