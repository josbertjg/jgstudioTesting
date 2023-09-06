<div class="col-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Agregar categoría de producto</h2>
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

      <form method="POST" class="form" enctype="multipart/form-data">
        <div class="row">
          <div class="col-sm-6 col-12">
            <label for="" >Nombre</label>
            <input type="text" name="nombre" class="form-control">
          </div>
          <div class="col-sm-6 col-12">
            <label for="image">Imagen</label>
            <input type="file" name="file"><br>
          </div>
          <input type="submit" value="Añadir" class="btn btn-primary col-12 mt-3">
        </div>
      </form>
    </div>
  </div>
</div>

<div class="col-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Listado de categorías</h2>
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
            <th class="column-title">Imagen</th>
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
            // debuguear($productos)

            for($i = 0;$i<count($category);$i++){
              ?>
                <tr class="<?php echo ($i % 2 == 0) ? 'even' : 'odd' ?> pointer">
                  <td class=" "><?php echo $category[$i]->nombre; ?></td>
                  <td class=" ">
                    <!-- <picture>
                            <source srcset="<?php echo '/img/categories/' . $category[$i]->imagen; ?>" type="image/webp">
                            <source srcset="<?php echo '/img/categories/' . $category[$i]->imagen; ?>" type="image/png">
                            <img class="" loading="lazy" width="100" height="100"
                            src="<?php echo '/img/categories/'. $category[$i]->imagen; ?>"
                            alt="<?php echo $category[$i]->imagen; ?>">
                    </picture> -->
                    <picture>
                            <source srcset="<?php echo $category[$i]->imagen; ?>" type="image/webp">
                            <source srcset="<?php echo $category[$i]->imagen; ?>" type="image/png">
                            <img class="" loading="lazy" width="100" height="100"
                            src="<?php echo $category[$i]->imagen; ?>"
                            alt="<?php echo $category[$i]->imagen; ?>">
                    </picture>
                  </td>
                  <td class="a-right a-right "><?php echo ($category[$i]->estado == 1) ? 'Activo' : 'Inactivo' ?></td>
                  <td class=" last">
                    <a href="/admin/productos/productoDetail?id=<?php echo $category[$i]->id ?>"><i class="fa-solid fa-eye btn btn-primary"></i></a>
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