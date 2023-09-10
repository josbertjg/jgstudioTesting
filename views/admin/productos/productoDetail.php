<div class="col-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Editar producto</h2>
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
          <input type="hidden" name="id" value="<?php echo $producto->id ?>">
          <div class="col-sm-6 col-12">
            <label for="" >Nombre</label>
            <input type="text" name="nombre" class="form-control soloLetras editable" value="<?php echo $producto->nombre ?>">
          </div>
          <div class="col-sm-6 col-12">
            <label for="" >Descripción</label>
            <input type="text" name="descripcion" class="form-control soloLetras editable" value="<?php echo $producto->descripcion ?>">
          </div>
          <div class="col-sm-6 col-12">
            <label for="" >Precio unitario</label>
            <input type="text" name="precio_unitario" class="form-control editable" value="<?php echo $producto->precio_unitario ?>">
          </div>
          <div class="col-sm-6 col-12">
            <label for="" >Cantidad máxima</label>
            <input type="number" name="cantidad_maxima" class="form-control editable" value="<?php echo $producto->cantidad_maxima ?>">
          </div>
          <div class="col-sm-6 col-12">
            <label for="">Categoría</label>
            <select name="id_categoria" class="form-control editable">
              <option value="1" <?php echo $producto->id_categoria == 1 ? 'selected' : '' ?>>Desarrollo</option>
              <option value="2" <?php echo $producto->id_categoria == 2 ? 'selected' : '' ?>>Diseño</option>
              <option value="3" <?php echo $producto->id_categoria == 3 ? 'selected' : '' ?>>Redes Sociales</option>
              <option value="4" <?php echo $producto->id_categoria == 4 ? 'selected' : '' ?>>Otro</option>
            </select>
          </div>
          <div class="col-sm-6 col-12">
            <label for="">Estado</label>
            <select name="estado" class="form-control" disabled>
              <option value="1" <?php echo $producto->estado == 1 ? 'selected' : '' ?>>Activo</option>
              <option value="2" <?php echo $producto->estado == 0 ? 'selected' : '' ?>>Inactivo</option>
            </select>
          </div>
          <div class="col-sm-6 col-12">
            <label for="">Fecha de creación</label>
            <input type="text" name="fecha_creacion" class="form-control" value="<?php echo $producto->fecha_creacion ?>" disabled>
          </div>
          <div class="col-sm-6 col-12">
            <label for="">Última Fecha de actualización</label>
            <input name="fecha_modificacion" type="text" class="form-control" value="<?php echo $producto->fecha_modificacion ?>" disabled>
          </div>
          <div class="col-12 d-flex justify-content-end mt-3">
            <input type="button" value="Editar" class="btn btn-outline-primary btnEditar">
            <input type="submit" value="Guardar" class="btn btn-success btnGuardar">
            <a href="/admin/productos" class="btn btn-primary btnVolver">Volver</a>          
          </div>
        </div>
      </form>
    </div>
  </div>
</div>