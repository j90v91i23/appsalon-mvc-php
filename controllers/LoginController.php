<?php 
namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;



class LoginController{

  
    public static function login(Router $router){
        
        $alertas =[];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);
            
            $alertas=$auth->validarLogin();

            if(empty($alertas)){
                //comprobar si el usuario exite
                $usuario=Usuario::where('email',$auth->email);

                if($usuario){
                    //verificar el password es por el interprete no lo encuentra pero esat e ususio
                    
                   if( $usuario->comprobarPasswordAndVerificar($auth->password)){
                    //autenticar el ususario
                    isSession();

                    
                    $_SESSION['id'] = $usuario->id;
                    $_SESSION['nombre']  =$usuario->nombre . " " . $usuario->apellido;
                   

                    $_SESSION['email']  =$usuario->email; 
                    $_SESSION['login']  =true; 

                    //si es admin o no
                    if($usuario->admin === "1"){
                        $_SESSION['admin']  = $usuario->admin  ?? null;

                        header("Location: /admin");
                        


                    }else{
                        header("Location: /cita");
                    }
                 

                    
                   }

                }else{
                    Usuario::setAlerta('error','usuario no encontrado');
                }
               

            }
        }

        $alertas=Usuario::getAlertas();





        $router->render('auth/login',[
            
            'alertas'=> $alertas
        ]);
        
    }

    public static function logout(){
       
        //debuguear($_SESSION);
        isSession();//session_star() replazado por el actual
        $_SESSION = [];

        header('Location: /');
       
    

    }

    public static function olvide(Router $router){
        $alertas= [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);
            $alertas =  $auth->validarEmail();
           
            if(empty($alertas)){
                $usuario = Usuario::where('email', $auth->email);

                if($usuario && $usuario->confirmado === "1"){
                
                    //GENERAR UN TOKEN DE UN SOLO USO
                
                $usuario->crearToken();
                

                
                $usuario->guardar();
                
                // all enviar email
                $email =new Email($usuario->email,$usuario->nombre,$usuario->token);
                $email->enviarInstrucciones();
                
                
                //lerta de exito
                Usuario::setAlerta('exito','revisa tu correo ');




                
                }else{
                    Usuario::setAlerta('error','El Usuario no existe o no esta confirmado');
                    
                }
               
          

           }

           
           
           
        
            

        }
        $alertas=Usuario::getAlertas();
    
       
        $router->render('auth/olvide-password',[
        'alertas' => $alertas

        ]);

    }
        

    public static function recuperar(Router $router){
        $alertas=[];
        $error = false;

        $token = s($_GET['token']);
        
        //buscar al usuario por su token
        $usuario = Usuario::where('token',$token);
        
        if(empty($usuario)){
            Usuario::setAlerta('error','Token no Válido');
            $error = true;

        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //lee el nuevo passowrd y gauradlo
            
            
            $password = new Usuario($_POST);
            
            $alertas = $password->validarPassword();

            if(empty($alertas)){
                $usuario->password= null;

                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token=null;
                
               $resultado =  $usuario->guardar();

               if($resultado){
                header('Location: /');
               }
                
            }
            
        }
        
        
        $alertas = Usuario::getAlertas();
        
        $router->render('auth/recuperar-password', [
            'alertas' => $alertas, 
            'error' => $error
        ]);
    }

    public static function crear(Router $router){
        
        $usuario = new Usuario;

        
        //Alertas vacias
        $alertas=[];
        if($_SERVER['REQUEST_METHOD']==='POST'){

            $usuario->sincronizar($_POST);
            $alertas=$usuario->ValidarNuevaCuenta();
            
            
            //Revisar que alerta este vacio
            if(empty($alertas)){
                //verficar que no este registrado
                
                $resultado=$usuario->exiteUsuario();

                
                if($resultado->num_rows){
                    $alertas = Usuario::getAlertas();
                }else{
                    //Hashear el password
                    $usuario->hashPassword();

                    //generer un toke unico
                    $usuario->crearToken();

                    //enviar un email secrea una carpeta name classes

                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);

                    $email->enviarConfirmacion();

                    //crear el usuario
                    
                    $resultado=$usuario->guardar();


                 // debuguear($resultado);

                    if($resultado){
                        header('Location: /mensaje');
                    }
                }

            
            }
       
        }
        
              //mustra la vista
            $router->render('auth/crear-cuenta', [
            'usuario'=>$usuario,
            'alertas'=> $alertas
            
            
            ]);
    }

    public static function mensaje(Router $router){
        
        $router->render('auth/mensaje');
    }

    public static function confirmar(Router $router){
        $alertas=[];
        $token =s($_GET['token']);
        
        $usuario = Usuario::where('token',$token);

        if(empty($usuario) || $usuario->token === ''){
            //mostar un mesaje de error

            Usuario::setAlerta('error','Token no valido');
            

        }else{
            //Modificar  a usuario confirmado
            $usuario->confirmado = "1";
            $usuario-> token = '';
            
            $usuario->guardar();
            Usuario::setAlerta('exito','cuenta comprobada correctamente');
        }
  
        $alertas=Usuario::getAlertas();
        
        $router->render('auth/confirmar-cuenta',[
            'alertas' => $alertas
        ]);
        
    }



    

}





