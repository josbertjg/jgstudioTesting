<h1>Pagos Pendientes</h1>
<div class="container-fluid pagos-container">
  <div class="accordion" id="accordionPago">
    <?php 
      include "../views/templates/alertas.php";
      ?>
    <?php 
      if(count($pagos)>0){
        foreach($pagos as $pago): 
    ?>
      <div class="accordion-item pago-item">
        <h2 class="accordion-header pago-header">
          <a class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $pago->id ?>" aria-expanded="true" aria-controls="collapse<?php echo $pago->id ?>">
            <img src="/build/img/pago.png" alt="">
            <div>
              <h2 class="m-0 mb-2"><b>Pago</b> <span><?php echo formatFecha($pago->fecha_pago) ?></span></h2>
              <p class="m-0 text-secondary"><b>Usuario: </b><?php echo $pago->usuario->nombre.' '.$pago->usuario->apellido ?></p>
              <p class="m-0 text-secondary"><b>Correo: </b><?php echo $pago->usuario->correo ?></p>
              <p class="m-0 text-secondary"><b>Monto: </b><?php echo $pago->monto ?>$</p>
            </div>
          </a>
        </h2>
        <hr>
        <div id="collapse<?php echo $pago->id ?>" class="accordion-collapse collapse" data-bs-parent="#accordionPago">
          <div class="accordion-body pago-body d-flex flex-column">
            <div class="d-flex">
              <section class="info-pago">
                <h2>Información del Pago</h2>
                <p>Monto: <b><?php echo $pago->monto ?>$</b></p>
                <p>Fecha: <b><?php echo formatFecha($pago->fecha_pago) ?></b></p>
                <p>Tipo: <b><?php echo ($pago->id_tipo_pago < 3) ? 'Transferencia' : 'Efectivo' ?></b></p>
                <?php if(!empty($pago->referencia)): ?>
                  <p>Referencia: <b><?php echo $pago->referencia ?></b></p>
                <?php endif; ?>
                <?php if(!empty($pago->comprobante)): ?>
                  <p>Comprobante:</p>
                  <img src="<?php echo $pago->comprobante ?>">
                <?php endif; ?>
              </section>
              <section class="info-usuario">
                <h2>Información del Usuario:</h2>
                <p>Nombre: <b><?php echo $pago->usuario->nombre.' '.$pago->usuario->apellido ?></b></p>
                <p>Correo: <b><?php echo $pago->usuario->correo ?></b></p>
                <p>Celular: <b><?php echo $pago->usuario->telefono_celular ?></b></p>
                <p>Telefono Fijo: <b><?php echo $pago->usuario->telefono_fijo ?></b></p>
                <p>Documento: <b><?php echo $pago->usuario->numero_documento ?></b></p>
                <p>Dirección: <b><?php echo $pago->usuario->direccion ?></b></p>
              </section>
            </div>
            <div class="d-flex justify-content-end mt-3">
              <form method="POST">
                <input type="hidden" name="action" value="rechazar_pago">
                <input type="hidden" name="id_pago" value="<?php echo $pago->id ?>">
                <input type="submit" class="btn-rechazar" value="Rechazar">
              </form>
              <form method="POST">
                <input type="hidden" name="action" value="aprobar_pago">
                <input type="hidden" name="id_pago" value="<?php echo $pago->id ?>">
                <input type="submit" class="btn-submit" value="Aprobar">
              </form>
            </div>
          </div>
        </div>
      </div>
    <?php 
        endforeach; 
      }else{
        ?>
          <h2>No tienes ningún Pago pendiente.</h2>
        <?php
      }
    ?>
  </div>
</div>