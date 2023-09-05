<?php

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
    header('location: '.$_SERVER['PATH_INFO']);
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
