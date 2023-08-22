<?php

namespace MVC;

class Router
{
    public $getRoutes = [];
    public $postRoutes = [];

    public function get($url, $fn)
    {
        $this->getRoutes[$url] = $fn;
    }

    public function post($url, $fn)
    {
        $this->postRoutes[$url] = $fn;
    }

    public function comprobarRutas()
    {

        $url_actual = $_SERVER['PATH_INFO'] ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {
            $fn = $this->getRoutes[$url_actual] ?? null;
        } else {
            $fn = $this->postRoutes[$url_actual] ?? null;
        }

        if ( $fn ) {
            call_user_func($fn, $this);
        } else {
            echo "Página No Encontrada o Ruta no válida";
        }
    }

    public function render($view, $datos = [])
    {
        foreach ($datos as $key => $value) {
            $$key = $value; 
        }
        
        ob_start(); 
        
        include_once __DIR__ . "/views/$view.php";
        
        $contenido = ob_get_clean(); // Limpia el Buffer
        // debuguear($datos);
        $routeName = '';
        if(isset($datos['routeName'])) $routeName = $datos['routeName'];
        
        // Utilizar el layout de acuerdo a la URL
        $url_actual = $_SERVER['PATH_INFO'] ?? '/';
        if(strlen($url_actual)==1 || str_contains($url_actual,'login') || str_contains($url_actual,'signin')){
            include_once __DIR__ . '/views/layout_inicio.php';
        } else if(str_contains($url_actual,'admin')){
            include_once __DIR__ . '/views/admin_layout.php';
        }else{
            include_once __DIR__ . '/views/layout.php';
        }
        
    }
}
