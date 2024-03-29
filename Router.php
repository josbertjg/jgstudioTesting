<?php

namespace MVC;

class Router
{
    public $getRoutes = [];
    public $postRoutes = [];
    public $putRoutes = [];

    public function get($url, $fn)
    {
        $this->getRoutes[$url] = $fn;
    }

    public function post($url, $fn)
    {
        $this->postRoutes[$url] = $fn;
    }

    public function put($url, $fn)
    {
        $this->putRoutes[$url] = $fn;
    }

    public function comprobarRutas()
    {

        $url_actual = strtok($_SERVER['REQUEST_URI'], '?') ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {
            $fn = $this->getRoutes[$url_actual] ?? null;
        } else if ($method === 'POST') {
            $fn = $this->postRoutes[$url_actual] ?? null;
        } else {
            $fn = $this->putRoutes[$url_actual] ?? null;
        }

        if ( $fn ) {
            call_user_func($fn, $this);
        } else {
            // echo "Página No Encontrada o Ruta no válida";
            $this->render('error404',['pageNotFound'=>true]);
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
        $pageNotFound = false;
        if(isset($datos['pageNotFound'])) $pageNotFound = $datos['pageNotFound'];
        
        if(!$pageNotFound){
            // Utilizar el layout de acuerdo a la URL
            $url_actual = strtok($_SERVER['REQUEST_URI'], '?') ?? '/';
            if(strlen($url_actual)==1 || str_contains($url_actual,'login') || str_contains($url_actual,'signin')){
                include_once __DIR__ . '/views/layout_inicio.php';
            } else if(str_contains($url_actual,'admin')){
                include_once __DIR__ . '/views/admin_layout.php';
            }else{
                include_once __DIR__ . '/views/layout.php';
            }
        }else echo $contenido;
        
    }
}
