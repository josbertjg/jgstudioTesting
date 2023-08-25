$(".producto").change((e)=>{
  const producto = $(e.target)
  const allProductos = $(`.producto-categoria-${producto.attr('categoria_id')}`)
  const productoToSend = $(`.producto-${producto.attr('producto_id')}`)
  const total = $(`.total-${producto.attr('categoria_id')}`)
  const btnAddCarrito = $(`.add-carrito-${producto.attr('categoria_id')}`)
  btnAddCarrito.attr('disabled',true)

  // Se revisa si se debe desbloquear el boton de añadir al carrito
  let acumCantidad = 0 
  allProductos.each(function(index, element) {
    if( !isNaN(parseInt(element.value)) ){ // Es un campo de texto
      acumCantidad+=parseInt(element.value)
    }else{ //Es un switch
      let sw = $(element)
      acumCantidad += sw.is(':checked') ? 1 : 0
    }
  });
  btnAddCarrito.attr('disabled',!acumCantidad>0) //Se bloquea o no el boton de añadir

  if( !isNaN(parseInt(producto.val())) ){ //CAMPOS DE TEXTO
    if(producto.val() < 0) producto.val(0)
    if(parseInt(producto.val()) > parseInt(producto.attr('cantidad_maxima'))) producto.val(producto.attr('cantidad_maxima'))

    try{

      const value = JSON.parse(productoToSend.val())
   
      let acumPrecio = 0
      allProductos.each(function(index, element) {
        if( !isNaN(parseInt(element.value)) ){ // Es un campo de texto
          acumPrecio+=parseInt(element.value) * parseFloat($(element).attr('precio'))
        }else{ //Es un switch
          let sw = $(element)
          acumPrecio += sw.is(':checked') ? parseFloat(sw.attr('precio')) : 0
        }
      });

      // Se asigna el precio en el total
      if(parseInt(value.cantidad_producto) != parseInt(producto.val())){
        total.text(acumPrecio)
      }

      // Se agrega la nueva cantidad al input hidden
      value.cantidad_producto = producto.val()
      productoToSend.val(JSON.stringify(value))
      
    }catch(e){
      producto.val(0)
      Swal.fire({
        icon: 'error',
        title: 'Ocurrió un error inesperado',
        text: e,
      })
    }
  }else{ //SWITCHES
    try{
      const value = JSON.parse(productoToSend.val())
      const cantidad = producto.is(':checked') ? 1 : 0

      if(parseInt(value.cantidad_producto) > cantidad)
        total.text((parseFloat(total.text())-parseFloat(producto.attr('precio'))).toFixed(2))
      else
        total.text((parseFloat(total.text())+parseFloat(producto.attr('precio'))).toFixed(2))


      value.cantidad_producto = cantidad
      productoToSend.val(JSON.stringify(value))

    }catch(e){
      producto.val(0)
      Swal.fire({
        icon: 'error',
        title: 'Ocurrió un error inesperado',
        text: e,
      })
    }
  }
  
  //Validando que al dar click en el boton se vacien todos los campos
  btnAddCarrito.click(()=>{
    $('.producto').val(0)
  })
})
document.getElementsByClassName('producto').onpaste = (e)=>{
  e.preventDefault();
  return false
}
$(".producto").keydown(()=>{
  return false;
})
