<div class="col-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Agregar producto</h2>
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

      <form method="POST" class="form">
        <div class="row">
          <div class="col-sm-6 col-12">
            <label for="" >Nombre</label>
            <input type="text" name="nombre" class="form-control">
          </div>
          <div class="col-sm-6 col-12">
            <label for="">Descripción</label>
            <input type="text" name="descripcion" class="form-control">
          </div>
          <div class="col-sm-6 col-12">
            <label for="">Precio unitario</label>
            <input type="number" min="0" step="1" name="precio_unitario" class="form-control">
          </div>
          <div class="col-sm-6 col-12">
            <label for="">Categoría</label>
            <select name="id_categoria" class="form-control">
              <option value="0" selected>Seleccione una opción</option>
              <option value="1">Desarrollo</option>
              <option value="2">Redes Sociales</option>
              <option value="3">Diseñador</option>
              <option value="4">Otro</option>
            </select>
          </div>
          <input type="submit" value="Añadir producto" class="btn btn-primary col-12 mt-3">
        </div>
      </form>
    </div>
  </div>
</div>

<div class="col-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Listado de productos</h2>
      <ul class="navbar-right panel_toolbox">
        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        <!-- <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="#">Settings 1</a>
              <a class="dropdown-item" href="#">Settings 2</a>
          </div>
        </li>
        <li><a class="close-link"><i class="fa fa-close"></i></a> -->
        </li>
      </ul>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
    <div class="table-responsive">
      <table class="table table-striped jambo_table bulk_action">
        <thead>
          <tr class="headings">
            <th class="column-title">Nombre</th>
            <th class="column-title">Descripción</th>
            <th class="column-title">Precio unitario</th>
            <th class="column-title">Categoría</th>
            <th class="column-title">Estado</th>
            <th class="column-title no-link last"><span class="nobr">Actions</span>
            </th>
            <!-- <th class="bulk-actions" colspan="7">
              <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
            </th> -->
          </tr>
        </thead>

        <tbody>
          <?php
            // debuguear($users)
            for($i = 0;$i<count($productos);$i++){
              ?>
                <tr class="<?php echo ($i % 2 == 0) ? 'even' : 'odd' ?> pointer">
                  <td class=" "><?php echo $productos[$i]->nombre; ?></td>
                  <td class=" "><?php echo $productos[$i]->descripcion; ?></td>
                  <td class=" "><?php echo $productos[$i]->precio_unitario; ?></td>
                  <td class=" ">
                    <?php 
                      switch($productos[$i]->id_categoria){ 
                        case 1: echo 'Desarrollo'; break;
                        case 2: echo 'Diseño'; break;
                        case 3: echo 'Redes Sociales'; break;
                        case 4: echo 'Otro'; break;
                        default: echo 'Desarrollo';
                      } 
                    ?>
                  </td>
                  <td class="a-right a-right "><?php echo ($productos[$i]->estado == 1) ? 'Activo' : 'Inactivo' ?></td>
                  <td class=" last">
                    <a href="/admin/dashboard/productos/productoDetail?id=<?php echo $productos[$i]->id ?>"><i class="fa-solid fa-eye btn btn-primary"></i></a>
                    <a href="#"><i class="fa-solid fa-trash btn btn-danger"></i></a>
                  </td>
                </tr>
              <?php
            }
          ?>
        </tbody>
      </table>
    </div>
    </div>
  </div>
</div>