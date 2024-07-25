<?php 
namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController {
    public static function index(Router $router){
        isSession();
        isAdmin();
        $fecha = $_GET['fecha'] ?? date('Y-m-d');
        $fechas = explode('-', $fecha);
       
        if(!checkdate($fechas[1],$fechas[2],$fechas[0])){
            header('Location: /404');

        }
        
      
        
        //Consultar la base de datos

        $consulta = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre,' ', usuarios.apellido) as cliente, ";
        $consulta .=" usuarios.email, usuarios.telefono,
        servicios.nombre as servicio, servicios.precio ";
        $consulta .=" from citas ";
        $consulta .=" LEFT OUTER JOIN usuarios ";
        $consulta .=" ON usuarios.id = citas.usuarioId ";
        $consulta .=" LEFT OUTER JOIN citasservicios ";
        $consulta .=" on citasservicios.citaid=citas.id ";
        $consulta .=" left outer join servicios ";
        $consulta .=" on servicios.id=citasservicios.servicioid ";
        $consulta .=" WHERE fecha = '{$fecha}' ";

        $citas = AdminCita::SQL($consulta);
      

        
        //VISTAS
        $router-> render('admin/index', [
            'nombre' => $_SESSION['nombre'],
            'citas'=> $citas,
            'fecha'=>$fecha
        ]);
    }
    
}
