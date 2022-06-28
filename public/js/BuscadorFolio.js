var folio = document.querySelector('#folio_doctor')
var nombre_doctor = document.querySelector('#nombre_doctor');
var timeBuscador = ""
folio.value = ""
nombre_doctor.value =""

folio.addEventListener('keyup', () => {
    clearTimeout(timeBuscador);
    this.timeBuscador = setTimeout(traerFolio, 560);
})

function traerFolio() {
    var numero_folio = folio.value
    axios({
            method: 'get',
            url: '/api/mostrar/folio?folio=' + numero_folio
        })
        .then(res => {
            if (res.data) {
                nombre_doctor.value = res.data
            }
        })
        .catch(erro => console.log())

}
