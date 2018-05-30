<?php
/**
 * Crea links de navegacion relativos, segun la pagina en que se esta
 * soporta "/index.php" y "/views/.*"
 * @param string $uri link que se quiere crear, utilizar con slash al principio (ej : /views/inventory/index.php)
 * @return string
 */
function nav_link($uri) {
    //si es link externo, no lo tocamos
    if(strpos($uri, "http") !== false)
        return $uri;

    //removemos el caso home
    $actual_uri = str_replace('/index.php', "", "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");

    //si la actual uri contiene "views", eliminamos para dejar en raiz
    $actual_uri_views_pos = strpos($actual_uri, '/views');
    if($actual_uri_views_pos !== false)
        $actual_uri = substr($actual_uri, 0, $actual_uri_views_pos);

    return $actual_uri . $uri;
}

/**
 * Para el menu principal retorna active para el link seleccionado
 * @param $uri
 * @return string
 */
function menu_item_active($uri) {
    $actual_uri = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $nav_link = nav_link($uri);
    return $actual_uri == $nav_link ? "active" : "";
}

/**
 * Incluye el layout head HTML, como argumentos se pueden pasar css que se quiera agregar
 */
function require_head() {
    $links = func_get_args();
    require_once ROOT_PATH.'/views/layout/head.php';
}

/**
 * Incluye el layout foot HTML, como argumentos se pueden pasar js que se quieran agregar
 */
function require_foot(){
    $scripts = func_get_args();
    require_once ROOT_PATH.'/views/layout/foot.php';
}

function hash_password($password){
    return password_hash($password, PASSWORD_BCRYPT);
}