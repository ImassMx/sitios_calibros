

    var codigo = document.querySelector('#codigo_postal')
    var alcaldia = document.querySelector('#alcaldia')
    var ciudad = document.querySelector('#ciudad')
    var estado = document.querySelector('#estado')

   codigo.value=""
   alcaldia.value=""
   ciudad.value=""
   estado.value=""
   var timeBuscador=""
    codigo.addEventListener('keyup', ()=>{
        
        clearTimeout(timeBuscador);
      this.timeBuscador = setTimeout(traerCodigo, 360);

    })

    function traerCodigo()
    {
      var cos = codigo.value
      axios({
          method:'get',
          url:'/api/codigo/postal?codigo='+cos
      })
      .then(res => {
        
          if(res.data.d_codigo){
              this.alcaldia.value= res.data.d_mnpio
              this.ciudad.value=res.data.d_ciudad
              this.estado.value=res.data.d_estado
          
          }else if(res.data.d_codigo=== undefined){
              this.alcaldia.value=""
              this.ciudad.value=""
              this.estado.value=""
          }
      })
      .catch(error => console.log(error))
    }


    function buscar(){
        
    }

