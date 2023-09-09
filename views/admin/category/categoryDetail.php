<div class="col-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Editar categoría</h2>
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
          <input type="hidden" name="id" value="<?php echo $categoria->id ?>">
          <div class="col-sm-6 col-12">
            <label for="" >Nombre</label>
            <input type="text" name="nombre" class="form-control soloLetras editable" value="<?php echo $categoria->nombre ?>">
          </div>
          <div class="col-sm-6 col-12">
            <label for="">Estado</label>
            <select name="estado" class="form-control" disabled>
              <option value="1" <?php echo $categoria->estado == 1 ? 'selected' : '' ?>>Activo</option>
              <option value="2" <?php echo $categoria->estado == 0 ? 'selected' : '' ?>>Inactivo</option>
            </select>
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