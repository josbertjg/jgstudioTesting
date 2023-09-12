<h1>Mis Proyectos</h1>
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
              <h2 class="m-0 mb-2"><b>Proyecto <?php echo $proyecto->nombre ?></b></h2>
              <p class="m-0 text-secondary"><b>Categoría: </b><?php echo $proyecto->categoria->nombre ?></p>
              <p class="m-0 text-secondary"><b>Estado: </b><?php echo $proyecto->estado ?></p>
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
              <p class="text-secondary mr-4"><b>Nota Importante:</b> En cuanto se haya culminado con todo lo que contiene el proyecto, debe dar click en culminar para finalizar y cerrar este proyecto.</p>
              <form method="POST" class="d-flex align-items-center">
                <input type="hidden" name="id_proyecto" value="<?php echo $proyecto->id ?>">
                <button class="btn-submit d-flex align-items-center">
                  <i class="fa-solid fa-flag mr-2"></i>
                  Culminar
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