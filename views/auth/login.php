<div class="container my-5">
  <?php 
  echo $titulo;
  for ($i = 0; $i < count($alertas); $i++) {
    echo $alertas['error'][$i];
  }
  ?>

  <form method="POST" class="form">
    <label for="" >Correo</label>
    <input type="email" name="correo" class="form-control">
    <label for="">Password</label>
    <input type="password" name="clave" class="form-control">
    <input type="submit" class="btn btn-primary">
  </form>
  <a href="/signin">Registrate</a>
</div>
