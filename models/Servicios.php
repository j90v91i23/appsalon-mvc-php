<?php 
// models se crean para poder consultar la basese de datos , son las clases

namespace Model;
 class servicios extends ActiveRecord{
    //bases de datos
    protected static $tabla = 'servicios';
    protected static $columnasDB = ['id','nombre','precio'];

    public $id;
    public $nombre;
    public $precio;


    public function __construct($args = [])
    {
       $this->id=$args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->precio = $args['precio'] ?? '' ;
    }
    public function validar()
    {
        if(!$this->nombre){
            self::$alertas['error'][] = 'El Nombre del Servicio es obligatorio';
        }
        if(!$this->precio){
            self::$alertas['error'][] = 'El Precio del Servicio es obligatorio';
        }

        if(!is_numeric($this->precio)){
            self::$alertas['error'][] = 'El Precio no es válido';
        }

        return self::$alertas;
    }
 }