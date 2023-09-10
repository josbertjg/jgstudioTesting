<?php

$imageCategoryPath = '/img/categories/';
$imageBankPath = '/img/banks/';
$imageUserAvatarPath = '/img/avatar/';
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

// Guardar imagen en la ruta del proyecto
function uploadImage($newFile, $modelImage){

    if(!empty($newFile)) {

        $file = $_FILES['file'];
        $filename = $file['name'];
        $relativePath;

        //debuguear($filename);

        switch($modelImage){
            // POST Para Eliminar un articulo del carrito
            case 'Category':
                $relativePath = $GLOBALS['path'] . $GLOBALS['imageCategoryPath'];
                $realPath = $GLOBALS['imageCategoryPath'];
                //debuguear($relativePath);
                break;
            // POST Para Culminar el registro
            case 'UserAvatar': 
                $relativePath = $GLOBALS['path'] . $GLOBALS['imageUserAvatarPath'];
                $realPath = $GLOBALS['imageUserAvatarPath'];
            break;
            // POST Para realizar pago
            case 'Bank':
                $relativePath = $GLOBALS['path'] . $GLOBALS['imageBankPath'];
                $realPath = $GLOBALS['imageBankPath'];
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
