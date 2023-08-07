/*
    NOTAS DEL PROYECTO:
    -AL EJECUTARSE EL EVENTO SCROLL SE ESTA EJECUTANDO UNA OPERACION MATEMATICA QUE REALENTIZA LA CARGA Y UX
    DE LA PAGINA, SE DEBEN GUARDAR DICHOS DATOS EN VARIABLES AL CARGARSE LA PAGINA PARA EVITAR ESTO
    LUEGO UTILIZAR DICHAS VARIABLES EN LAS CONDICIONES, PARA EN VEZ DE USAR EL PROCEDIMIENTO USAR LOS VALORES
    DE LOS MISMOS.

*/

/* DEFINIENDO VARIABLES */

//BOLLEANO QUE DETERMINA EL CAMBIO DEL MENU
let darEstiloMenu=true;
//VARIABLES QUE CAMBIAN LA APARIENCIA DEL MENU
let h1,nav,distancia;
$(document).ready(()=>{
    /* INICIALIZANDO VARIABLES */
    //HAYANDO LA POSICION DEL H1 DEL HEAD PARA SABER CUANDO CAMBIAR EL MENU
    h1=parseInt($("header h1").position().top);
    //HAYANDO EL ALTO DEL MENU PARA REALIZAR LA CONDICION DEL CAMBIO DEL MENU
    nav=parseInt($("nav").height())/2;
    //HAYANDO LA DISTANCIA ENTRE AMBOS VALORES ANTERIORES
    distancia=h1-nav;
 
    /* FUNCIONALIDADES AL CARGAR LA PAGINA */

    //DANDO ESTILO AL MENU
    if(window.scrollY>=distancia && darEstiloMenu){
        addMenuStyles("/build/img/logo.png");
        darEstiloMenu=false; 
    }else
        //QUITANDO ESTILOS AL MENU
        if(window.scrollY<=distancia && !darEstiloMenu){
            removeMenuStyles("/build/img/logo-white.png");
            darEstiloMenu=true;
        }

    //BOTONES DE MODULOS EN DESARROLLO
    $("nav li:nth-of-type(5), #portafolio > a,footer a[href='#blog']").click(()=>{
        Swal.fire({
            icon: 'info',
            title: 'En Desarrollo',
            text: '¡Gracias por tu interés, aún estamos trabajando en ello!',
        })
    });

    //ENVIANDO EL CORREO CON MAILTO
    $("#btnCorreo").click((event)=>{
        event.preventDefault();
        if($("#nombre").val().trim().length==0 || $("#email").val().trim().length==0 || $("#mensaje").val().trim().length==0){
            Swal.fire({
                icon: 'error',
                title: 'No se puso enviar el correo',
                text: 'No deben haber campos vacíos en el formulario.',
            })
        }else
            if(!validarCorreo($("#email").val())){
                Swal.fire({
                    icon: 'error',
                    title: 'No se puso validar el correo',
                    text: 'Debe ingresar una dirección de correo válida para continuar',
                })
            }else{
                $("#btnMailto").attr("href",`mailto:neopixelsve@gmail.com?subject=${"¡Hola! mi nombre es "+$("#nombre").val()+" Y quiero trabajar con ustedes... "+$("#email").val()}&body=${$("#mensaje").val()}&`)
                document.getElementById("btnMailto").click();
                $("#nombre").val("");
                $("#email").val("");
                $("#mensaje").val("");
            }
    });

    /* EVENTOS */
    
    //CAMBIO DEL MENU AL HACER SCROLL
    $(window).scroll(()=>{
        //DANDO ESTILO AL MENU
        if(window.scrollY>distancia && darEstiloMenu){
            addMenuStyles("/build/img/logo.png");
            darEstiloMenu=false; 
        }else
            //QUITANDO ESTILOS AL MENU
            if(window.scrollY<distancia && !darEstiloMenu){
                removeMenuStyles("/build/img/logo-white.png");
                darEstiloMenu=true;
            }
    });
    //EVITAR NUMEROS EN EL INPUT DE NOMBRE
    $("#nombre").keydown((event)=>{
        return soloLetras(event)
    });
});



