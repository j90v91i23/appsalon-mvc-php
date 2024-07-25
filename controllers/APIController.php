<?php 

namespace Controllers;
use Model\Cita;
use Model\CitaServicios;
use Model\Servicios;

class APIController{
    public static function index(){
        $servicios =Servicios::all();
      echo json_encode($servicios);
    }

    public static function  guardar(){
      //almacena cita y el id
      $cita = new Cita($_POST);
      //debuguear($cita);
      $resultado = $cita-> guardar();
      $id = $resultado['id'];

      //Almacenanlos servicos con elid cita
     
      $idServicios = explode(",", $_POST['servicios']);

      foreach($idServicios as $idservicio){
        $args =[
          
          'citaid' =>$id,
          'servicioid' =>$idservicio
        ];
        
        $citaServicio = new CitaServicios($args);
        
        //debuguear($citaServicio);
        //exit();
        
        $citaServicio->guardar();

      }
     
     
        echo json_encode(['resultado' =>$resultado]);
      //debuguear($resultado);
    }
    public static function eliminar(){
       if($_SERVER['REQUEST_METHOD'] === 'POST'){
       
       
        
       
        $id=$_POST['id']; 
        $cita = Cita::find($id);
        $cita->eliminar();
        header('Location:' . $_SERVER['HTTP_REFERER']);
       
   
       
        

      
       
        
       

       }
    }
}

