<?php 

namespace Classes;
use PHPMailer\PHPMailer\PHPMailer;


class Email{
    public $email;
    public $nombre;
    public $token;
    public function __construct($email,$nombre,$token)
    {
        
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion(){
        //crear un objeto email

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['ENAIL_PASS'];


        $mail->setFrom('jvi90@hotmail.com');
        $mail->addAddress('jesus@hotmail.com.com', 'appsalon.com');    
        $mail->Subject='Confirma tu cuenta';
        

        //set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p> <strong> hola: " . $this->email . " </strong>Has creado una cuenta en APP Salon, confirma presionado el siguiente enlace </p>";

        $contenido .= "<p> Presiona aqui: <a href='" . $_ENV['APP_URL']  . "/confirmar-cuenta?token=" .$this->token . "'>Confirmar cuenta</a></p>";

        $contenido .="<p>Si tu no solicitaste esta cuenta, puedes ignorar este mensaje</p>";

        $contenido .= "</html>";

        $mail->Body = $contenido;

        //ENVIAR EL EAMIL
        $mail->send();




    

    }

    public function enviarInstrucciones(){
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['ENAIL_PASS'];



        $mail->setFrom('jvi90@hotmail.com');
        $mail->addAddress('jesus@hotmail.com.com', 'appsalon.com');    
        $mail->Subject='Restablece tu password';
        

        //set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p> <strong> hola: " . $this->nombre . " </strong> Has solicitado restablecer tu password sigue el siguiente enlace para hacerlo. </p>";

        $contenido .= "<p> Presiona aqui: <a href='" . $_ENV['APP_URL']  . "/recuperar?token=" .$this->token . "'>Restablecer  Password</a></p>";

        $contenido .="<p>Si tu no solicitaste esta cuenta, puedes ignorar este mensaje</p>";

        $contenido .= "</html>";

        $mail->Body = $contenido;

        //ENVIAR EL EAMIL
        $mail->send();

    }





}