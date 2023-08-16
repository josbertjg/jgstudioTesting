<div class="col-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Añadir un Usuario</h2>
      <ul class="navbar-right panel_toolbox">
        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        <!-- <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="#">Settings 1</a>
              <a class="dropdown-item" href="#">Settings 2</a>
          </div>
        </li>
        <li><a class="close-link"><i class="fa fa-close"></i></a>
        </li> -->
      </ul>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <?php 
        include "../views/templates/alertas.php";
      ?>

      <form method="POST" class="form formEditar">
        <div class="row">
          <input type="hidden" name="id" value="<?php echo $user->id ?>">
          <div class="col-sm-6 col-12">
            <label for="" >Nombre</label>
            <input type="text" name="nombre" class="form-control soloLetras editable" value="<?php echo $user->nombre ?>">
          </div>
          <div class="col-sm-6 col-12">
            <label for="">Apellido</label>
            <input type="text" name="apellido" class="form-control soloLetras editable" value="<?php echo $user->apellido ?>">
          </div>
          <div class="col-sm-6 col-12">
            <label for="">Correo</label>
            <input type="email" name="correo" class="form-control <?php echo is_admin() ? 'editable' : '' ?>" <?php echo !is_admin() ? 'disabled' : '' ?> value="<?php echo $user->correo ?>">
          </div>
          <div class="col-sm-6 col-12">
            <label for="">Contraseña</label>
            <input type="password" name="clave" class="form-control editable" value="<?php echo $user->clave ?>">
          </div>
          <div class="col-sm-6 col-12">
            <label for="">Alias</label>
            <input type="text" name="alias" class="form-control editable" value="<?php echo $user->alias ?>">
          </div>
          <div class="col-sm-6 col-12">
            <label for="">Avatar</label>
            <input type="text" name="avatar" class="form-control editable" value="<?php echo $user->avatar ?>">
          </div>
          <div class="col-sm-6 col-12">
            <label for="">Nro Documento</label>
            <input type="text" name="numero_documento" class="form-control soloNumeros editable" value="<?php echo $user->numero_documento ?>">
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
            <input type="text" name="direccion" class="form-control editable" value="<?php echo $user->direccion ?>">
          </div>
          <div class="col-sm-6 col-12">
            <label for="">País</label>
            <input type="text" name="id_pais" class="form-control editable" value="<?php echo $user->id_pais ?>">
          </div>
          <div class="col-sm-6 col-12">
            <label for="">Estado</label>
            <input type="text" name="id_estado" class="form-control editable" value="<?php echo $user->id_estado ?>">
          </div>
          <div class="col-sm-6 col-12">
            <label for="">Nro Celular</label>
            <input type="text" name="telefono_celular" class="form-control soloNumeros editable" value="<?php echo $user->telefono_celular ?>">
          </div>
          <div class="col-sm-6 col-12">
            <label for="">Nro Fijo</label>
            <input type="text" name="telefono_fijo" class="form-control soloNumeros editable" value="<?php echo $user->telefono_fijo ?>">
          </div>
          <div class="col-sm-6 col-12">
            <label for="">Rol del Usuario</label>
            <select name="id_rol" class="form-control editable">
              <option value="0" <?php echo $user->id_rol == 5 ? 'selected' : '' ?>>Cliente</option>
              <option value="1" <?php echo $user->id_rol == 2 ? 'selected' : '' ?>>Programador</option>
              <option value="1" <?php echo $user->id_rol == 3 ? 'selected' : '' ?>>Publicista</option>
              <option value="1" <?php echo $user->id_rol == 4 ? 'selected' : '' ?>>Diseñador</option>
              <option value="1" <?php echo $user->id_rol == 1 ? 'selected' : '' ?> disabled>Super Administrador</option>
            </select>
          </div>
          <div class="col-sm-6 col-12">
            <label for="">Estado del Usuario</label>
            <select name="estado" class="form-control" disabled>
              <option value="1" <?php echo $user->estado == 1 ? 'selected' : '' ?>>Activo</option>
              <option value="2" <?php echo $user->estado == 0 ? 'selected' : '' ?>>Inactivo</option>
            </select>
          </div>
          <div class="col-sm-6 col-12">
            <label for="">Fecha de Creación</label>
            <input type="text" class="form-control" value="<?php echo $user->fecha_creacion ?>" disabled>
          </div>
          <div class="col-sm-6 col-12">
            <label for="">Última Fecha de actualización</label>
            <input type="text" class="form-control" value="<?php echo $user->fecha_modif ?>" disabled>
          </div>
          <div class="col-12 d-flex justify-content-end mt-3">
            <input type="button" value="Editar" class="btn btn-outline-primary btnEditar">
            <input type="submit" value="Guardar" class="btn btn-primary btnGuardar">
          </div>
        </div>
      </form>
    </div>
  </div>
</div>