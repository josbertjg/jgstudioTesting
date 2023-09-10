<div class="col-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Editar banco</h2>
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
          <input type="hidden" name="id" value="<?php echo $banco->id ?>">
          <div class="col-sm-6 col-12">
            <label for="" >Nombre</label>
            <input type="text" name="nombre" class="form-control soloLetras editable" value="<?php echo $banco->nombre ?>">
          </div>
          <div class="col-sm-6 col-12">
            <label for="" >Código</label>
            <input type="text" name="codigo" class="form-control soloNumeros editable" value="<?php echo $banco->codigo ?>">
          </div>
          <div class="col-sm-6 col-12" style="margin-top: 2%;">
            <label for="">Imagen/logo</label>
            <br>
            <img class="" loading="lazy" width="100" height="100" src="<?php echo $banco->imagen; ?>" alt="<?php echo $banco->imagen; ?>">
          </div>
          <div class="col-12 d-flex justify-content-end mt-3">
            <input type="button" value="Editar" class="btn btn-outline-primary btnEditar">
            <input type="submit" value="Guardar" class="btn btn-success btnGuardar">
            <a href="/admin/banco" class="btn btn-primary btnVolver">Volver</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>