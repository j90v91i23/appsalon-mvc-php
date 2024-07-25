<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

function esUltimo( String $actual,string $proximo): bool {
    if($actual !== $proximo){
        return true;
    }
    return false;

}




function iniciaSecion(){
    if(!isset($_SESSION)){
        isSession();
    }


}

//Función que revisa que el ususario este autenticado

function isAuth() : void{
    if(!isset($_SESSION['login'])){
        header('Location: /');
    }
}
//para los usaurios REPETIR session_start();
function isSession() : void{
    if (!isset($_SESSION)) {
        session_start();
        
    }
}

function isAdmin() : void {
    if(!isset($_SESSION['admin'])) {
        header('Location: /');
    }
}
