<h1>Proyectos Pendientes</h1>
<div class="container-fluid proyectos-container">
  <div class="accordion" id="accordionProyecto">
    <?php 
      include "../views/templates/alertas.php";
      ?>
    <?php 
      if(count($proyectos)>0){
        foreach($proyectos as $proyecto): 
    ?>
      <div class="accordion-item proyecto-item">
        <h2 class="accordion-header proyecto-header">
          <a class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $proyecto->id ?>" aria-expanded="true" aria-controls="collapse<?php echo $proyecto->id ?>">
            <img src="/build/img/proyecto.png" alt="">
            <div>
              <h2 class="m-0 mb-2"><b>Proyecto<?php echo $proyecto->nombre ?></b></h2>
              <p class="m-0 text-secondary"><b>Categoría: </b><?php echo $proyecto->categoria->nombre ?></p>
              <p class="m-0 text-secondary"><b>Estado: </b>Por hacer</p>
            </div>
          </a>
        </h2>
        <hr>
        <div id="collapse<?php echo $proyecto->id ?>" class="accordion-collapse collapse" data-bs-parent="#accordionProyecto">
          <div class="accordion-body proyecto-body d-flex flex-column">
            <div class="d-flex">
              <section class="info-proyecto">
                <h2>Detalles del Proyecto</h2>
                <?php foreach($proyecto->productos as $producto): ?>
                  <p><b>-<?php echo $producto->nombre ?>: </b><?php echo ($producto->nombre == 'Cotizacion') ? '<br>'.$proyecto->detalles  : $producto->descripcion ?></p>
                <?php endforeach; ?>
              </section>
              <section class="info-usuario">
                <h2>Información del Contrato:</h2>
                <p>Usuario: <b><?php echo $proyecto->contrato->usuario->nombre.' '.$proyecto->contrato->usuario->apellido ?></b></p>
                <p>Correo: <b><?php echo $proyecto->contrato->usuario->correo ?></b></p>
                <p>Celular: <b><?php echo $proyecto->contrato->usuario->telefono_celular ?></b></p>
                <p>Telefono Fijo: <b><?php echo $proyecto->contrato->usuario->telefono_fijo ?></b></p>
                <p>Documento: <b><?php echo $proyecto->contrato->usuario->numero_documento ?></b></p>
                <p>Dirección: <b><?php echo $proyecto->contrato->usuario->direccion ?></b></p>
                <p>Monto: <b><?php echo $proyecto->contrato->monto?>$</b></p>
              </section>
            </div>
            <div class="d-flex justify-content-center align-items-center mt-3">
              <p class="text-secondary"><b>Nota Importante:</b> El proyecto cambiará al estado <b>"En Curso"</b> cuando asigne un empleado para que trabaje en el, de lo contrario, el proyecto no podrá cambiar de estado.</p>
              <form method="POST" class="d-flex align-items-center">
                <input type="hidden" name="id_proyecto" value="<?php echo $proyecto->id ?>">
                <select name="id_empleado" class="form-control mr-3">
                  <?php 
                    if(count($empleados)>0){
                      foreach($empleados as $i=>$empleado): 
                  ?>
                    <option value="<?php echo $empleado->id ?>" <?php ($i == 0) ? 'selected' : '' ?>><?php echo $empleado->nombre ?> - <?php echo $empleado->rol ?></option>
                  <?php 
                      endforeach;
                    }else{
                      ?>
                        <option selected>Sin Empleados</option>
                      <?php
                    }
                  ?>
                </select>
                <button class="btn-submit d-flex align-items-center">
                  <i class="fa-solid fa-plus mr-1"></i>
                  Asignar
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    <?php 
        endforeach; 
      }else{
        ?>
          <h2>No tienes ningún Proyecto pendiente.</h2>
        <?php
      }
    ?>
  </div>
</div>