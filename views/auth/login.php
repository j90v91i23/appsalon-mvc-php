<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inica sesión con tus datos</p>



<?php include_once __DIR__ .'/../templates/alertas.php'; ?>

<form action="/" class="formularion" method="POST">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email"
        id="email"
        placeholder="Tu Email"
        name="email"
        />
    </div>
    <div class="campo">
        <label for="password">Password</label>
        <input type="password"
        id="password"
        placeholder="Coloca Tu Password"
        name="password"
        
        />

    </div>
    <input type="submit" class="boton" value="Iniciar Sesión" >

</form>

<div class="acciones">
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crea una</a>
    <a href="/olvide">¿Olvidastes tu password?</a>

</div>