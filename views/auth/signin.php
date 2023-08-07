<div class="container my-5">
  <?php 
  echo $titulo;
  for ($i = 0; $i < count($alertas); $i++) {
    echo $alertas['error'][$i];
  }
  ?>

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