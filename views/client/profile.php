<?php 
  include "../views/templates/alertas.php";
?>

<div class="col-12">
  <div class="x_panel">
    <form method="POST" class="form formEditar" enctype="multipart/form-data">
      <div class="row">
        <input type="hidden" name="id" value="<?php echo $client->id ?>">
        <div class="col-sm-12 col-12">
          <label for="">Avatar</label>
        </div>
        <div class="col-sm-6 col-12" style="padding-bottom: 2%;">
          <!-- <input type="text" name="avatar" class="form-control editable" value="<?php echo $client->avatar ?>"> -->
          <img class="" loading="lazy" width="100" height="100" src="<?php echo $client->avatar; ?>">
        </div>
        <div class="col-sm-6 col-12" style="margin-top:2%;">
            <input type="file" name="file"><br>
        </div>
        <div class="col-sm-6 col-12">
          <label for="" >Nombre</label>
          <input type="text" name="nombre" class="form-control soloLetras editable" value="<?php echo $client->nombre ?>">
        </div>
        <div class="col-sm-6 col-12">
          <label for="">Apellido</label>
          <input type="text" name="apellido" class="form-control soloLetras editable" value="<?php echo $client->apellido ?>">
        </div>
        <div class="col-sm-6 col-12">
          <label for="">Correo</label>
          <input type="email" name="correo" class="form-control soloLetras editable" value="<?php echo $client->correo ?>">
        </div>
        <div class="col-sm-6 col-12">
          <label for="">Contraseña</label>
          <input type="password" name="clave" class="form-control editable" value="<?php echo $client->clave ?>">
        </div>
        <div class="col-sm-6 col-12">
          <label for="">Alias</label>
          <input type="text" name="alias" class="form-control editable" value="<?php echo $client->alias ?>">
        </div>
        <div class="col-sm-6 col-12">
          <label for="">Nro Documento</label>
          <input type="text" name="numero_documento" class="form-control" editable value="<?php echo $client->numero_documento ?>">
          
        </div>
        <div class="col-sm-6 col-12">
          <label for="">Tipo de Documento</label>
          <select name="tipo_documento" class="form-control" disabled>
            <option value="0">Pasaporte</option>
            <option value="1" selected>Cedula</option>
          </select>
        </div>
        <div class="col-sm-6 col-12">
          <label for="">Dirección</label>
          <input type="text" name="direccion" class="form-control editable" value="<?php echo $client->direccion ?>">
        </div>
        <div class="col-sm-6 col-12">
          <label for="">País</label>
          <input type="text" name="id_pais" class="form-control editable" value="<?php echo $client->id_pais ?>">
        </div>
        <div class="col-sm-6 col-12">
          <label for="">Estado</label>
          <input type="text" name="id_estado" class="form-control editable" value="<?php echo $client->id_estado ?>">
        </div>
        <div class="col-sm-6 col-12">
          <label for="">Nro Celular</label>
          <input type="text" name="telefono_celular" class="form-control soloNumeros editable" value="<?php echo $client->telefono_celular ?>">
        </div>
        <div class="col-sm-6 col-12">
          <label for="">Nro Fijo</label>
          <input type="text" name="telefono_fijo" class="form-control soloNumeros editable" value="<?php echo $client->telefono_fijo ?>">
        </div>
        <div class="col-12 d-flex justify-content-end mt-3">
          <input type="button" value="Editar" class="btn btn-outline-primary btnEditar">
          <input type="submit" value="Guardar" class="btn btn-primary btnGuardar">
        </div>
      </div>
    </form>
  </div>
</div>