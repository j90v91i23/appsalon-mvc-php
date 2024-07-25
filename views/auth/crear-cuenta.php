<h1 class="nombre-pagina">Crear cuenta</h1>
<p class="descripcion-pagina">Llena el siguiente formulario para crear una cuenta</p>
  <?php  include_once __DIR__ . "/../templates/alertas.php"; ?>
<form class="formulario"  method="POST" action="/crear-cuenta">
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" placeholder="escribe tu nombre" value="<?php  echo s($usuario->nombre); ?>" >

    </div>
    <div class="campo">
        <label for="apellido">Apellido</label>
        <input type="text" id="apellido" name="apellido" placeholder="escribe tu apellido" 
        value="<?php  echo s($usuario->apellido); ?>">

    </div>
    
    <div class="campo">
        <label for="telefono">Teléfono</label>
        <input type="tel" id="telefono" name="telefono" placeholder="escribe tu Teléfono" value="<?php  echo s($usuario->telefono); ?>">

    </div>

    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="escribe tu email" value="<?php  echo s($usuario->email); ?>">

    </div>

    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="escribe tu password" >

    </div>

    <input type="submit" value="Crear cuenta" class="boton">

</form>


<div class="acciones">
    <a href="/">¿Cuentas con una cuenta? Inicia Sesión </a>
    <a href="/olvide">¿Olvidastes tu password?</a>

</div>