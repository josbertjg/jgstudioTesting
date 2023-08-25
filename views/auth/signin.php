<header id="inicio">
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
</header>
<div class="container my-5">
  <input type="hidden" class="jg-alert" value='<?php echo json_encode($alertas) ?>'>
  <form method="POST" class="form">
    <label for="" >Nombre</label>
    <input type="text" name="nombre" class="form-control">
    <label for="" >Apellido</label>
    <input type="text" name="apellido" class="form-control">
    <label for="" >Correo</label>
    <input type="email" name="correo" class="form-control">
    <label for="">Password</label>
    <input type="password" name="clave" class="form-control">
    <input type="submit" class="btn btn-primary">
  </form>
  <a href="/login">¿Ya tienes una cuenta?</a>
</div>