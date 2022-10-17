const valores = window.location.search;
const urlParams = new URLSearchParams(valores);
var producto = urlParams.get("folio");

var inputFolio = document.querySelector('#folio')
var email = document.querySelector('#email')
var mensaje = document.querySelector('.error')

if (producto !== "") {
    inputFolio.value = producto
    if (inputFolio.value.length > 4) {
        var url = '/api/mostrar/datos/doctor/' + producto;

        fetch(url, {
                method: 'GET',
            }).then(res => res.json())
            .catch(error => {
                mensaje.innerHTML = "El número de folio es incorrecto."
            })
            .then(response => {
                email.value = response.email
            });
    }
}
if (producto === "" || producto === null) {
    inputFolio.addEventListener("keyup", (e) => {

        console.log(e.target.value)
        inputFolio.value = e.target.value

        if (inputFolio.value.length > 4) {
            var url = '/api/mostrar/datos/doctor/' + e.target.value;

            fetch(url, {
                    method: 'GET',
                }).then(res => res.json())
                .catch(error => {
                    mensaje.innerHTML = "El número de folio es incorrecto."
                })
                .then(response => {
                    email.value = response.email
                    mensaje.innerHTML = ""
                });
        }

    })

}
