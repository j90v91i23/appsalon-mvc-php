<h1 class="nombre-pagina">Olvide Password</h1>
<p class="descripcion-pagina">Restablece tu password escribiendo tu email a continuación</p>


<?php  include_once __DIR__ . "/../templates/alertas.php"; ?>


<form  class="formulario" action="/olvide" method="POST" >
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Coloca tu correo"/>
                
             
                

    </div>

    <input type="submit" class="boton" value="Enviar Instrucciones">
   

</form>


<div class="acciones">
    <a href="/">¿Cuentas con una cuenta? Inicia Sesión </a>
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crear Una</a>

</div>