<header id="inicio">
    <div class="signin">
        <h1><?php echo $titulo ?></h1>
        <p><?php echo $descripcion ?></p>
        <div>
            <?php 
                if($hasLogin){
            ?>
                <a href="/login">Login</a>
            <?php
                } if($hasSignin){
            ?>
                <a href="/signin">Registrate</a>
            <?php 
                } if($hasContact){
            ?>
                <a href="/#contacto">Contáctanos</a>
            <?php } ?>
        </div>
    </div>
</header>
<div class="">
  <input type="hidden" class="jg-alert" value='<?php echo json_encode($alertas) ?>'>
  <div class="signin-form-container">
    <div>
        <h5>¡Que estas esperando!</h5>
        <h1>Registrate</h1>
        <p>Comienza a disfrutar de nuestros servicios <b>¡YA!</b></p>
        <form method="POST" class="form">
            <input type="text" name="nombre" class="form-control mb-3" placeholder="Nombre:">
            <input type="text" name="apellido" class="form-control mb-3" placeholder="Apellido:">
            <input type="email" name="correo" class="form-control mb-3" placeholder="Correo:">
            <input type="password" name="clave" class="form-control mb-3" placeholder="Contraseña:">
            <input type="submit" class="btn-submit">
        </form>
        <a href="/login">¿Ya tienes una cuenta?</a>
    </div>
    <img src="build/img/signin-form.png" alt="">
</div>