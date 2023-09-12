<?php

use Model\Cotizacion;
use Model\Pago;
use Model\UsuarioProyecto;
use Model\Proyecto;

$imageCategoryPath = '/img/categories/';
$imageBankPath = '/img/banks/';
$imageUserAvatarPath = '/img/avatar/';
$imagePagosPath = '/img/pagos/';
$path = '../public';

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

function pagina_actual($path) : bool {
    return str_contains($_SERVER['PATH_INFO'], $path) ? true : false;
}

function is_auth() {
    if(!isset($_SESSION)){
        session_start();
    }
    return isset($_SESSION['nombre']) && !empty($_SESSION);
}

function is_admin() : bool {
    if(!isset($_SESSION)) {
        session_start();
    }
    return is_auth() && ($_SESSION['id_rol'] == 1);
}

function is_admin_empleado() : bool {
    if(!isset($_SESSION)) {
        session_start();
    }
    return is_auth() && ($_SESSION['id_rol'] == 1 || $_SESSION['id_rol'] == 2 || $_SESSION['id_rol'] == 3 || $_SESSION['id_rol'] == 4);
}

function is_empleado() : bool {
    if(!isset($_SESSION)) {
        session_start();
    }
    return is_auth() && ($_SESSION['id_rol'] == 2 || $_SESSION['id_rol'] == 3 || $_SESSION['id_rol'] == 4);
}

function is_programador() : bool {
    if(!isset($_SESSION)) {
        session_start();
    }
    return is_auth() && ($_SESSION['id_rol'] == 2);
}

function is_publicista() : bool {
    if(!isset($_SESSION)) {
        session_start();
    }
    return is_auth() && ($_SESSION['id_rol'] == 3);
}

function is_diseñador() : bool {
    if(!isset($_SESSION)) {
        session_start();
    }
    return is_auth() && ($_SESSION['id_rol'] == 4);
}

function is_cliente() : bool {
    if(!isset($_SESSION)) {
        session_start();
    }
    return is_auth() && ($_SESSION['id_rol'] == 5);
}

function showRol($id_rol){
    switch($id_rol){
        case 1: return 'Super Administrador';
        case 2: return 'Programador';
        case 3: return 'Publicista';
        case 4: return 'Diseñador';
        case 5: return 'Cliente';
        default: return 'Otro';
    }
}

function currentUser_id() : int {
    return $_SESSION['id'];
}

function getCarrito(): array {
    if(empty($_SESSION['carrito'])){
        $_SESSION['carrito'] = [];
        $carrito = [];
    }else{
        $carrito = json_decode($_SESSION['carrito']);
    }
    return array_values($carrito);
}

function setCarrito($carrito) {
    $_SESSION['carrito'] = json_encode($carrito);
}

function deleteItemCarrito($id) {
    $carrito = getCarrito();
    if(count($carrito)>0){
        for($i = 0;$i<count($carrito);$i++){
            if($carrito[$i]->item_id == $id){
                unset($carrito[$i]);
                $carrito = array_values($carrito);
                setCarrito($carrito);
                break;
            }
        }
    }
}

function getNotifications(): array {
    $notifications = [];

    if(is_admin()){ // Si es admin
        // Obteniendo Cotizaciones Pendientes.
        $cotizaciones = Cotizacion::getPendientes();
        if(count($cotizaciones)>0){
            $objCotizacion = (object)[];
            foreach($cotizaciones as $cotizacion){
                $objCotizacion->nombre = 'Cotización';
                $objCotizacion->imagen = '/build/img/cotizacion.png';
                $objCotizacion->mensaje = $cotizacion->solicitud;
                $objCotizacion->fecha = timeAgo($cotizacion->fecha);
    
                array_push($notifications, $objCotizacion);
            }
        }
    
        // Obteniendo Pagos Pendientes
        $pagos = Pago::getPendientes();
        if(count($pagos)>0){
            $objPago = (object)[];
            foreach($pagos as $pago){
                $tipoPago = $pago->id_tipo_pago < 3 ? 'Transferencia' : 'Efectivo';
    
                $objPago->nombre = 'Pago';
                $objPago->imagen = '/build/img/pago.png';
                $objPago->mensaje = $tipoPago.': '.$pago->monto.'$';
                $objPago->fecha = timeAgo($pago->fecha_pago);
    
                array_push($notifications, $objPago);
            }
        }
    }else if(is_empleado()){ // Si no es admin y es un empleado
        // Obteniendo Proyectos asignados
        $userProyectos = UsuarioProyecto::all();
        if(count($userProyectos)>0){
            $objProyecto = (object)[];
            foreach($userProyectos as $userProyecto){

                $proyecto = Proyecto::find($userProyecto->id_proyecto);

                if($proyecto->id_estado_proyecto == 5){
        
                    $objProyecto->nombre = 'Proyecto';
                    $objProyecto->imagen = '/build/img/proyecto.png';
                    $objProyecto->mensaje = 'Se te ha asignado un nuevo proyecto.';
                    $objProyecto->fecha = timeAgo($proyecto->fecha);
        
                    array_push($notifications, $objProyecto);
                }

            }
        }
    }

    return $notifications;
}

// Guardar imagen en la ruta del proyecto
function uploadImage($newFile, $modelImage){

    if(!empty($newFile)) {

        $file = $_FILES['file'];
        $filename = $file['name'];
        $relativePath;

        //debuguear($filename);
        
        switch($modelImage){
            // Imagenes de categorias
            case 'Category':
                $relativePath = $GLOBALS['path'] . $GLOBALS['imageCategoryPath'];
                $realPath = $GLOBALS['imageCategoryPath'];
                //debuguear($relativePath);
                break;
            // Imagenes de usuarios
            case 'UserAvatar': 
                $relativePath = $GLOBALS['path'] . $GLOBALS['imageUserAvatarPath'];
                $realPath = $GLOBALS['imageUserAvatarPath'];
            break;
            // Imagenes de banco
            case 'Bank':
                $relativePath = $GLOBALS['path'] . $GLOBALS['imageBankPath'];
                $realPath = $GLOBALS['imageBankPath'];
            break;
            // Imagenes de pagos
            case 'Pago':
                $relativePath = $GLOBALS['path'] . $GLOBALS['imagePagosPath'];
                $realPath = $GLOBALS['imagePagosPath'];
            break;
            }

        //debuguear($relativePath);

        if(!is_dir($relativePath)) {
            mkdir($relativePath, 0755, true);
        }

        $fileNameAux = $filename;
        $targetFile = $relativePath . basename($_FILES['file']['name']);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        //debuguear($targetFile);

        $check = getimagesize($_FILES['file']['tmp_name']);
        //debuguear($check);

        $finalName = $filename;

        if ($check !== false) {
            if (file_exists($targetFile)) {
                $filename = pathinfo($targetFile, PATHINFO_FILENAME);
                $extension = pathinfo($targetFile, PATHINFO_EXTENSION);
                $counter = 1;
                while (file_exists($targetFile)) {
                    $newFilename = $filename . '_' . $counter . '.' . $extension;
                    $fileNameAux = $newFilename;
                    $targetFile = $relativePath . $newFilename;
                    $counter++;
                }
                $finalName = $newFilename;
            }

            if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
                //debuguear($newFilename);

                $realPath = $realPath.$finalName;
                //debuguear($realPath);

                return $realPath;
            } else {
                $alertas['error'][] = 'Hubo un error al subir la imagen.';
                echo 'Hubo un error al subir la imagen.';
                return $alertas;
            }
        } else {
            $alertas['error'][] = 'El archivo seleccionado no es una imagen válida.';
            echo 'El archivo seleccionado no es una imagen válida.';
            return $alertas;
        }
    }
}

// FORMATEO DE DATA

// Formatear fechas del back
function formatFecha($fecha) {
    $date=date_create($fecha);
    return date_format($date,"d/m/Y");
}

// Formatear diferencias de fechas del back con el presente
function timeAgo($fecha){

    $fecha_actual = date("Y-m-d H:i:s");

    $fecha_pasada = DateTime::createFromFormat('Y-m-d H:i:s', $fecha);
    $fecha_actual = DateTime::createFromFormat('Y-m-d H:i:s', $fecha_actual);

    $intervalo = date_diff($fecha_actual, $fecha_pasada);

    $segundos_transcurridos = $intervalo->s;
    $minutos_transcurridos = $intervalo->i;
    $horas_transcurridas = $intervalo->h;
    $dias_transcurridos = $intervalo->d;

    if( !$dias_transcurridos && !$horas_transcurridas && !$minutos_transcurridos ){
        return $segundos_transcurridos.'seg';
    }else if( !$dias_transcurridos && !$horas_transcurridas && $minutos_transcurridos ){
        return $minutos_transcurridos.'min';
    }else if( !$dias_transcurridos && $horas_transcurridas ){
        $subfijo = ($horas_transcurridas>1)? ' horas':' hora';
        return $horas_transcurridas.$subfijo;
    }else if($dias_transcurridos){
        $subfijo = ($dias_transcurridos>1)? ' días':' dia';
        return $dias_transcurridos.$subfijo;
    }
}
