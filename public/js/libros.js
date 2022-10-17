let btn_descarga = document.querySelector('#descargar-libro')
var numero_descarga = document.querySelector('#numerodescarga').value
var id_libro = document.querySelector('#id_libro').value
var id_usuario = document.querySelector('#id_usuario').value

let descargas_user = 0

btn_descarga.addEventListener('click', () => {
    if (descargas_user < 3) {
        let descargas = numero_descarga++
        axios({
                method: 'post',
                url: `/descarga/${id_libro}`,
                data: {
                    descarga: ++descargas,
                    id_usuario: id_usuario
                }
            }).then(response => {
                location.reload();
            })
            .catch(error => console.log(error))
    }else{
        btn_descarga.removeAttribute("donwload")
        btn_descarga.removeAttribute("href")
        Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: 'Alcanzó el limite de descargas.',
              })
    }
})
window.onload = function () {
    axios({
            method: 'get',
            url: `/api/validacion/descargas/${id_usuario}`,
        }).then(response => {
                descargas_user = response.data
                console.log(descargas_user)
        })
        .catch(error => console.log(error))
}
