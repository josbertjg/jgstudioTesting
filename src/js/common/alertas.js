/*
Nota: En esta hoja se realizaran las alertas respectivas 
guardadas en el value de un input hidden con la clase 'jg-alert'
*/
if($('.jg-alert').val()){
  try{
    let content = JSON.parse($('.jg-alert').val())
    let type = ''
    let title = ''
    let message = ''
    if(!Array.isArray(content)){
      if('error' in content){
        type = 'error'
        title = 'Oops...'
        for(let i = 0; i<content.error.length;i++){
          message += content.error[i]
          if(i<content.error.length-1) message += ', '
        }
      }
      if('success' in content){
        type = 'success'
        title = '¡Excelente!'
        for(let i = 0; i<content.success.length;i++){
          message += content.success[i]
          if(i<content.success.length-1) message += ', '
        }
      }
      if('info' in content){
        type = 'info'
        title = 'Importante:'
        for(let i = 0; i<content.info.length;i++){
          message += content.info[i]
          if(i<content.info.length-1) message += ', '
        }
      }
      if('warning' in content){
        type = 'warning'
        title = '¡Atención!'
        for(let i = 0; i<content.warning.length;i++){
          message += content.warning[i]
          if(i<content.warning.length-1) message += ', '
        }
      }
      Swal.fire({
        icon: type,
        title: title,
        text: message,
      })
    }
  }catch(e){
    Swal.fire({
      icon: 'error',
      title: 'Ocurrió un error inesperado',
      text: e,
    })
  }
}