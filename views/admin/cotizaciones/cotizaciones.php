<ul class="nav nav-tabs jgadmin-tabs-cotizaciones d-flex justify-content-center w-100" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <a class="nav-link active m-0" id="pendientes-tab" data-bs-toggle="tab" data-bs-target="#pendientes-tab-pane" type="button" role="tab" aria-controls="pendientes-tab-pane" aria-selected="true">Pendientes</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link m-0" id="completadas-tab" data-bs-toggle="tab" data-bs-target="#completadas-tab-pane" type="button" role="tab" aria-controls="completadas-tab-pane" aria-selected="false">Completadas</a>
  </li>
</ul>
<div class="tab-content w-100" id="myTabContent">
  <div class="px-5 my-3">
    <?php 
      include "../views/templates/alertas.php";
    ?>
  </div>
  <!-- PENDIENTES -->
  <div class="tab-pane fade show active w-100" id="pendientes-tab-pane" role="tabpanel" aria-labelledby="pendientes-tab" tabindex="0">
    <?php 
      if(count($pendientes)>0){
        foreach($pendientes as $cotizacion): 
    ?>
        <div class="accordion jgadmin-cotizacion-container" id="accordion<?php echo $cotizacion->id; ?>">
          <div class="accordion-item jgadmin-cotizacion-item">
            <h2 class="accordion-header">
              <a class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $cotizacion->id; ?>" aria-expanded="true" aria-controls="collapse<?php echo $cotizacion->id; ?>">
                <img src="/build/img/cotizacion.png" alt="cotizacion jgstudio">
                <div>
                  <h1 class="mb-0">Cotizacion <b><?php echo uniqid(); ?></b></h1>
                  <p class="text-secondary mb-0"><b>Solicitud: </b> <?php echo $cotizacion->solicitud ?> </p>
                  <p class="text-secondary mb-0"><b>Usuario: </b> <?php echo $cotizacion->nombre_usuario ?> </p>
                  <p class="text-secondary mb-0"><b>Correo: </b> <?php echo $cotizacion->correo_usuario ?> </p>
                </div>
              </a>
            </h2>
            <div id="collapse<?php echo $cotizacion->id; ?>" class="accordion-collapse collapse <?php echo $cotizacion->id == $idCotizacionWorked ? 'show' : '' ?>" data-bs-parent="#accordion<?php echo $cotizacion->id; ?>">
              <div class="accordion-body">
                <form method="POST">
                  <input type="hidden" name="action" value="aceptarCotizacion">
                  <input type="hidden" name="estado" value="2">
                  <input type="hidden" name="id" value="<?php echo $cotizacion->id ?>">
                  <input type="hidden" name="solicitud" value="<?php echo $cotizacion->solicitud ?>">
                  <input type="hidden" name="id_usuario" value="<?php echo $cotizacion->id_usuario ?>">
                  <h2 class="m-0">Enviar Cotización al cliente:</h2>
                  <p class="text-secondary m-0 mb-3">Recuerda que esta respuesta será enviada al cliente, el cual podra añadir esta cotizacion al carrito para poder comprarla.</p>
                  <!-- <label class="m-0 mb-1">Respuesta de la Cotización:</label> -->
                  <textarea class="form-control mb-3" name="respuesta" cols="30" rows="4" placeholder="Respuesta de la cotización: "></textarea>
                  <!-- <label class="m-0 mb-1">Monto final en dólares <b>($)</b>:</label> -->
                  <input class="form-control mb-3 soloNumeros" type="text" name="monto_final" placeholder="Monto final en dólares ($): ">
                  <div class="d-flex justify-content-end">
                    <!-- Button trigger modal -->
                    <a type="button" class="btn btn-danger rounded rounded-pill rechazar m-0 mr-2" data-bs-toggle="modal" data-bs-target="#rechazarModal">Rechazar Cotizacion</a>
                    <input class="btn-submit" type="submit" value="Aprobar y Enviar">
                  </div>
                </form>
                <!-- Modal -->
                <div class="modal fade modal-rechazar-cotizacion" id="rechazarModal" tabindex="-1" aria-labelledby="rechazarModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                        <h1 class="modal-title fs-5" id="rechazarModalLabel">Rechazar Cotización</h1>
                        <p class="text-secondary">¿Seguro que desea rechazar esta cotización?, debe explicar los motivos por los cuales rechazará esta cotización</p>
                        <form method="POST" class="d-flex flex-column">
                          <input type="hidden" name="action" value="rechazarCotizacion">
                          <input type="hidden" name="estado" value="3">
                          <input type="hidden" name="id" value="<?php echo $cotizacion->id ?>">
                          <input type="hidden" name="solicitud" value="<?php echo $cotizacion->solicitud ?>">
                          <input type="hidden" name="id_usuario" value="<?php echo $cotizacion->id_usuario ?>">
                          <label>Explique el motivo del rechazo: </label>
                          <textarea class="form-control" name="respuesta" cols="30" rows="3" placeholder="Motivo: "></textarea>
                          <div class="modal-footer pb-0 pr-0">
                            <a type="button" class="btn btn-primary text-light cancelar-rechazo" data-bs-dismiss="modal">Cancelar</a>
                            <input type="submit" class="btn btn-danger btnSubmit" value="Rechazar Cotizacion">
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /Modal -->
              </div>
            </div>
          </div>
        </div>
    <?php 
        endforeach; 
      }else{
        ?>
          <h1 class="d-flex justify-content-center align-items-center mt-5">No tienes cotizaciones pendientes.</h1>
        <?php
      }
    ?>
  </div>
  <!-- COMPLETADAS -->
  <div class="tab-pane fade" id="completadas-tab-pane" role="tabpanel" aria-labelledby="completadas-tab" tabindex="0">
    <div class="container-fluid d-flex justify-content-around flex-wrap align-items-center">
      <?php 
          if(count($completadas)>0){
            foreach($completadas as $cotizacion): 
        ?>
          <article class="cotizacion-completada-item">
            <img src="/build/img/cotizacion.png" alt="cotizacion jgstudio">
            <div>
              <h1 class="mb-0">Cotizacion <b><?php echo uniqid(); ?></b></h1>
              <p class="text-secondary mb-0"><b>Usuario: </b> <?php echo $cotizacion->nombre_usuario ?></p>
              <p class="text-secondary mb-0"><b>Correo: </b> <?php echo $cotizacion->correo_usuario ?></p>
              <p class="text-secondary mb-0"><b>Solicitud: </b> <?php echo $cotizacion->solicitud ?></p>
              <p class="text-secondary mb-0"><b><?php echo ($cotizacion->estado == 2) ? 'Respuesta' : 'Motivo' ?>: </b> <?php echo $cotizacion->respuesta ?></p>
              <span class="d-flex align-items-center text-secondary fw-bold">
                <b class="mr-1">Estado: </b> <b class="text-<?php echo ($cotizacion->estado == 2) ? 'success' : 'danger' ?>"><?php echo ($cotizacion->estado == 2) ? 'Aprobada' : 'Rechazada' ?> </b>
                <span class="ml-1 badge bg-<?php echo ($cotizacion->estado == 2) ? 'success' : 'red' ?>"> </span>
              </span>
            </div>
          </article>
        <?php 
            endforeach; 
          }else{
            ?>
              <h1 class="d-flex justify-content-center align-items-center mt-5">No tienes cotizaciones completadas.</h1>
            <?php
          }
        ?>
    </div>
  </div>
</div>
