let btn_descarga = document.querySelector('#descargar-libro')
        var numero_descarga = document.querySelector('#numerodescarga').value
        var id_libro = document.querySelector('#id_libro').value
        var id_usuario = document.querySelector('#id_usuario').value

        btn_descarga.addEventListener('click', () => {
            let descargas= numero_descarga++
            axios({
                    method: 'post',
                    url: `/descarga/${id_libro}`,
                    data:{descarga : ++descargas, id_usuario: id_usuario}
                }).then(response => console.log(response))
                .catch(error => console.log(error))
        })