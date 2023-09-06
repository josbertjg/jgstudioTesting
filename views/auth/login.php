<header id="inicio">
    <div class="login">
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
<main class="">
  <input type="hidden" class="jg-alert" value='<?php echo json_encode($alertas) ?>'>
  <div class="login-form-container">
    <div>
        <h5>¡Comienza a Disfrutar Ya!</h5>
        <h1>Inicia Sesión</h1>
        <p>Estaremos complacidos de <b>Atenderte</b></p>
        <form method="POST" class="form mb-2">
            <input type="email" name="correo" class="form-control my-4" placeholder="Correo:">
            <input type="password" name="clave" class="form-control mt-4" placeholder="Contraseña:">
            <input type="submit" class="mt-3 btn-submit">
        </form>
        <a href="/signin">Registrate</a>
    </div>
    <img src="build/img/login-form.png" alt="">
</main>
