/* 
Nota: En esta hoja se realizaran las validaciones para los formularios,
tener en cuenta que aca se usan las validaciones del archivo validaciones.js que se encuentra
en la arpeta build, tener esto presente ya que se usan funciones del archivo mencionado.
*/

// Edicion de Formularios
$('.editable').attr('disabled',true)
$('.btnEditar').click(()=>{
  $('.editable').attr('disabled',!$('.editable').attr('disabled'))
})
$('.btnGuardar').click((event)=>{
  event.preventDefault();
  $('.editable').attr('disabled',false)
  $('.formEditar').submit()
})


//Inputs
$('.soloLetras').keydown((e)=>{
  return soloLetras(e)
})
$('.soloNumeros').keydown((e)=>{
  return soloNumeros(e)
})