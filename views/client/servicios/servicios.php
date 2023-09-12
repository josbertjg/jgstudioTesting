<h1>Servicios Comprados</h1>
<div class="jg-servicios-comprados">
  <div class="row gap-4 d-flex">
    <?php 
      if(count($proyectos)>0){
        foreach($proyectos as $proyecto): 
    ?>
      <div class="col-md-5">
        <article class="servicio-item">
          <h2>Servicio <b><?php echo $proyecto->nombre ?></b></h2>
          <p class="mb-1 text-secondary"><b>Categoría: </b><?php echo $proyecto->categoria->nombre ?></p>
          <p class="mb-1 text-secondary"><b>Estado: </b>
            <?php 
              echo ($proyecto->id_estado_proyecto == 1) ? 'En revisión del pago' : ''; 
              echo ($proyecto->id_estado_proyecto == 4) ? 'En Etapa de Planificación' : ''; 
              echo ($proyecto->id_estado_proyecto != 1 && $proyecto->id_estado_proyecto != 4) ? $proyecto->estado : '';
            ?>
          </p>
          <div class="progress">
            <div 
              class="progress-bar progress-bar-striped bg-<?php 
                echo ($proyecto->id_estado_proyecto == 1) ? 'warning' : ''; 
                echo ($proyecto->id_estado_proyecto == 3) ? 'danger' : '';
                echo ($proyecto->id_estado_proyecto == 4 || $proyecto->id_estado_proyecto == 5) ? 'primary' : ''; 
                echo ($proyecto->id_estado_proyecto == 9) ? 'success' : ''; 
              ?>" 
              role="progressbar" 
              style="width: <?php 
                echo ($proyecto->id_estado_proyecto == 1) ? '10%' : ''; 
                echo ($proyecto->id_estado_proyecto == 3) ? '100%' : '';
                echo ($proyecto->id_estado_proyecto == 4) ? '20%' : ''; 
                echo ($proyecto->id_estado_proyecto == 5) ? '50%' : ''; 
                echo ($proyecto->id_estado_proyecto == 9) ? '100%' : ''; 
              ?>" 
              aria-valuenow="75" 
              aria-valuemin="0" 
              aria-valuemax="100">
            </div>
          </div>
        </article>
      </div>
    <?php 
        endforeach; 
      }else{
        ?>
          <h2 class="d-flex justify-content-center align-items-center mt-5">Aún no has realizado ningún pago o compra.</h2>
        <?php
      }
    ?>
  </div>
</div>