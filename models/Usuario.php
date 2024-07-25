<?php

namespace Model;

class Usuario extends ActiveRecord  {

    //BASE de datos
    protected static $tabla ='usuarios';
    protected static $columnasDB =['id','nombre','apellido','email','password','telefono','admin','confirmado','token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = [])
    {
        $this-> id = $args['id'] ?? null;
        $this-> nombre = $args['nombre'] ?? '';
        $this-> apellido = $args['apellido'] ?? '';
        $this-> email = $args['email'] ?? '';
        $this-> password = $args['password'] ?? '';
        $this-> telefono = $args['telefono'] ?? '';
        $this-> admin = $args['admin'] ?? '0';
        $this-> confirmado = $args['confirmado'] ?? '0';
        $this-> token = $args['token'] ?? '';
        
    }
    //mensaje de validación  para la creación
    
    public function  ValidarNuevaCuenta(){
        if(!$this->nombre){
            self::$alertas['error'][] = 'El Nombre del Cliente es Obligatorio';
    
        }
        if(!$this->apellido){
            self::$alertas['error'][] = 'El Apellido  es Obligatorio';
    
        }

        if(!$this->email){
            self::$alertas['error'][] = 'El email  es Obligatorio';
    
        }

        if(!$this->password){
            self::$alertas['error'][] = 'El password  es Obligatorio';
    
        }

        if(strlen($this->password) < 6){
            self::$alertas['error'][] = 'El password debe contener seis caracteres';
    
        }

        if(!$this->telefono){
            self::$alertas['error'][] = 'El Telefono  es Obligatorio';
    
        }

        
        return self::$alertas;
    }

    public function validarLogin(){//para iniciar logindel ususario
        if(!$this->email){
            self::$alertas['error'][] = 'El email es oblogatorio';

        }
        if(!$this->password){
            self::$alertas['error'][] = 'El password es oblogatorio';

        }
        return self::$alertas;
    }
    public function validarEmail(){
        if(!$this->email){
            self::$alertas['error'][] = 'El email es oblogatorio';

        }
        return self::$alertas;

    }

    public function validarPassword(){
        if(!$this->password){
            self::$alertas['error'][] = 'El Password es obligatorio';
        }
        if(strlen($this->password)  < 6 )  {
            self::$alertas['error'] [] = 'El password debe tener al menos 6 caracteres';
            
          

        }
        return self::$alertas;
    }




    //revisa si el usuario ya esta registrado
    public function exiteUsuario(){
        
        $query=" SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1" ;
    
        
        $resultado = self::$db->query($query);

        if($resultado->num_rows){
            self::$alertas['error'][] = 'El Usuario ya esta registardo';

        }
        return($resultado);
    }
    
    public function hashPassword(){
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }


    public function crearToken(){
        $this->token = uniqid();


    }

    public function comprobarPasswordAndVerificar($password){
        $resultado = password_verify($password, $this->password);

        if(!$resultado || !$this->confirmado){
            self::$alertas['error'][]= "El password es incorecto o tu cuenta no esta confirmada";
        }else{
            return true;
        }
       

    }

    
   


    

    
    

}