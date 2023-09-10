<h1>Mis Cotizaciones</h1>
<input type="hidden" class="jg-alert" value='<?php echo json_encode($alertas) ?>'>
<div class="jg-cotizaciones">
  <div class="row gap-4 d-flex">
    <?php 
      if(count($cotizaciones)>0){
        foreach($cotizaciones as $cotizacion): 
    ?>
      <div class="col-md-5">
        <article class="cotizacion-item">
          <h2><i class="fa-solid fa-magnifying-glass-dollar"></i> Cotización <b><?php echo uniqid(); ?></b></h2>
          <p class="mb-1 text-secondary"><b>Solicitud: </b><?php echo $cotizacion->solicitud ?></p>
          <?php if($cotizacion->estado > 1): ?>
            <p class="mb-1 text-secondary"><b><?php echo ($cotizacion->estado == 2) ? 'Respuesta' : 'Motivo' ?>: </b><?php echo $cotizacion->respuesta ?></p>
            <?php if($cotizacion->estado == 2): ?>
              <p class="mb-1 text-secondary"><b>Monto Total: </b><b class="monto-total"><?php echo $cotizacion->monto_final ?>$</b></p>
            <?php endif; ?>
          <?php endif; ?>
          <p class="mb-1 text-secondary">
            <b>Estado:</b>
            <?php echo ($cotizacion->estado == 1) ? 'Esperando Revisión' : ''; echo ($cotizacion->estado == 2) ? 'Aprobada' : ''; echo ($cotizacion->estado == 3) ? 'Rechazada' : '' ?>
          </p>
          <div class="progress">
            <div class="progress-bar progress-bar-striped bg-<?php echo ($cotizacion->estado == 1) ? 'warning' : ''; echo ($cotizacion->estado == 2) ? 'success' : ''; echo ($cotizacion->estado == 3) ? 'danger' : '' ?>" role="progressbar" style="width: <?php echo $cotizacion->estado > 1 ? '100%' : '50%' ?>" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
          <?php if($cotizacion->estado > 1): ?>
            <div class="d-flex justify-content-end mt-2">
              <form method="POST">
                <input type="hidden" name="action" value="deleteCotizacion">
                <input type="hidden" name="id" value="<?php echo $cotizacion->id ?>">
                <button class="deleteCotizacion">Eliminar <i class="fa-solid fa-trash"></i></button>
              </form>
              <?php if($cotizacion->estado == 2): ?>
                <form method="POST">
                  <input type="hidden" name="action" value="addToCarrito">
                  <input type="hidden" name="solicitud" value="<?php echo $cotizacion->solicitud ?>">
                  <input type="hidden" name="respuesta" value="<?php echo $cotizacion->respuesta ?>">
                  <input type="hidden" name="monto_final" value="<?php echo $cotizacion->monto_final ?>">
                  <input type="hidden" name="item_id" value="<?php echo uniqid(); ?>">
                  <button class="addToCarrito">Añadir al Carrito <i class="fa-solid fa-cart-shopping"></i></button>
                </form>
              <?php endif; ?>
            </div>
          <?php endif; ?>
        </article>
      </div>
    <?php 
        endforeach; 
      }else{
        ?>
          <h2 class="d-flex justify-content-center align-items-center mt-5">Aún no has realizado ninguna solicitud de cotización.</h2>
        <?php
      }
    ?>
  </div>
</div>