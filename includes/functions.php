<?php

function current_uri(){
    return "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
}
/**
 * Crea links de navegacion relativos, segun la pagina en que se esta
 * @param string $uri link que se quiere crear, utilizar con slash al principio (ej : /views/inventory/index.php)
 * @return string
 */
function nav_link($uri) {
    //si es link externo, no lo tocamos
    if(strpos($uri, "http") !== false)
        return $uri;

    //removemos el caso home
    $actual_uri = str_replace('/index.php', "", current_uri());

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
    $actual_uri = current_uri();
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

function redirect($uri){
    ob_start();
    header('Location: '. nav_link($uri));
    ob_end_flush();
    die();
}

function hash_password($password){
    return password_hash($password, PASSWORD_BCRYPT);
}

/**
 * prepara variables $_GET a un string para agregar a SQL query
 * @param $request_vars
 * @param string $conditional_separator
 * @return string
 */
function request_vars_to_search($request_vars, $conditional_separator = "OR"){
    $search_conditions = [];
    foreach($request_vars as $var_name) {
        if (isset($_REQUEST[$var_name]) && (!empty($_REQUEST[$var_name]) || $_REQUEST[$var_name] === '0')) {
            $operator = "=";
            $value = "'".$_REQUEST[$var_name]."'";
            if(preg_match('~(>|<|>=|<=)~', $_REQUEST[$var_name], $matches)) {
                $operator = $matches[0];
                $_REQUEST[$var_name] = str_replace($operator, '', $_REQUEST[$var_name]);
                $value = $_REQUEST[$var_name];
            }
            $search_conditions[] = "$var_name $operator $value";
        }
    }
    return implode(" $conditional_separator ", $search_conditions);
}

