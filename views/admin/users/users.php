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

      <form method="POST" class="form">
        <div class="row">
          <div class="col-sm-6 col-12">
            <label for="" >Nombre</label>
            <input type="text" name="nombre" class="form-control soloLetras">
          </div>
          <div class="col-sm-6 col-12">
            <label for="">Apellido</label>
            <input type="text" name="apellido" class="form-control soloLetras">
          </div>
          <div class="col-sm-6 col-12">
            <label for="">Correo</label>
            <input type="email" name="correo" class="form-control">
          </div>
          <div class="col-sm-6 col-12">
            <label for="">Contraseña</label>
            <input type="password" name="clave" class="form-control">
          </div>
          <div class="col-sm-6 col-12">
            <label for="">Nro Documento</label>
            <input type="text" name="numero_documento" class="form-control soloNumeros">
          </div>
          <div class="col-sm-6 col-12">
            <label for="">Dirección</label>
            <input type="text" name="direccion" class="form-control">
          </div>
          <div class="col-sm-6 col-12">
            <label for="">País</label>
            <select name="id_pais" class="form-control" disabled>
              <option value="1" selected>Afganistan</option>
            </select>
          </div>
          <div class="col-sm-6 col-12">
            <label for="">Nro Celular</label>
            <input type="text" name="numero_celular" class="form-control soloNumeros">
          </div>
          <div class="col-sm-6 col-12">
            <label for="">Nro Fijo</label>
            <input type="text" name="numero_fijo" class="form-control soloNumeros">
          </div>
          <div class="col-sm-6 col-12">
            <label for="">Rol del Usuario</label>
            <select name="id_rol" class="form-control">
              <option value="2" selected>Programador</option>
              <option value="3">Publicista</option>
              <option value="4">Diseñador</option>
              <option value="5">Cliente</option>
            </select>
          </div>
          <input type="submit" value="Añadir Usuario" class="btn btn-primary col-12 mt-3">
        </div>
      </form>
    </div>
  </div>
</div>

<div class="col-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Tabla de Usuarios</h2>
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
            <th class="column-title">Apellido</th>
            <th class="column-title">Correo</th>
            <th class="column-title">Clave</th>
            <th class="column-title">Rol</th>
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
            for($i = 0;$i<count($users);$i++){
              ?>
                <tr class="<?php echo ($i % 2 == 0) ? 'even' : 'odd' ?> pointer">
                  <td class=" "><?php echo $users[$i]->nombre; ?></td>
                  <td class=" "><?php echo $users[$i]->apellido; ?></td>
                  <td class=" "><?php echo $users[$i]->correo; ?></td>
                  <td class=" "><?php echo $users[$i]->clave; ?></td>
                  <td class=" ">
                    <?php 
                      switch($users[$i]->id_rol){ 
                        case 1: echo 'Super Administrador'; break;
                        case 2: echo 'Programador'; break;
                        case 3: echo 'Publicista'; break;
                        case 4: echo 'Diseñador'; break;
                        default: echo 'Cliente';
                      } 
                    ?>
                  </td>
                  <td class="a-right a-right "><?php echo ($users[$i]->estado == 1) ? 'Activo' : 'Inactivo' ?></td>
                  <td class=" last">
                    <a href="/admin/dashboard/users/userDetail?id=<?php echo $users[$i]->id ?>"><i class="fa-solid fa-eye btn btn-primary"></i></a>
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