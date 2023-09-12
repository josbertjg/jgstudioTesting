<h1><?php echo $titulo ?></h1>
<div class="row">
  <div class="col-md-6 carrito-productos-container">
    <h2>Productos Añadidos</h2>
    <div class="carrito-productos">
      <?php if(count($carrito)<=0) { ?>
        <h1>Tu Carrito esta vacio.</h1>
      <?php }else foreach($carrito as $item):
              if(!$item->isCotizacion){  
      ?>
        <article class="carrito-item-container">
          <img src="<?php echo $item->categoria->imagen ?>" alt="">
          <div class="carrito-item-information">
            <label class="carrito-item-title"><?php echo $item->categoria->nombre ?> <b><?php echo $item->item_id ?></b></label>
            <?php foreach($item->productos as $productoItem): ?>
              <div class="d-flex flex-column mt-1">
                <span>
                  <i class="fa-solid fa-check"></i>
                  <label class="carrito-product-title"><?php echo $productoItem->nombre ?> <b><?php echo $productoItem->precio_unitario ?></b></label>
                </span>
                <p class="carrito-product-description"><?php echo $productoItem->descripcion ?></p>
                <div class="d-flex align-items-center">
                  <span class="carrito-product-cantidad">Cantidad: <b><?php echo $productoItem->cantidad_producto ?></b></span>
                  <span class="mx-2 carrito-divider">|</span>
                  <span class="carrito-product-total">Total: <b>$<?php echo $productoItem->cantidad_producto * $productoItem->precio_unitario?></b></span>
                </div>
              </div>
            <?php endforeach; ?>
            <form method="POST" class="d-flex justify-content-end">
              <input type="hidden" name="action" value="delete_item_carrito">
              <input type="hidden" name="item_id" value="<?php echo $item->item_id ?>">
              <button class="btn-delete-item-carrito btn btn-danger">Eliminar <i class="fa-solid fa-trash"></i></button>
            </form>
          </div>
        </article>
      <?php 
          } else{
            ?>
              <article class="carrito-item-container">
                <img src="/build/img/cotizacion.png" alt="cotizacion jgstudio">
                <div class="carrito-item-information">
                  <label class="carrito-item-title">Cotización <b><?php echo $item->item_id ?></b></label>
                  <div class="d-flex flex-column mt-1">
                    <span>
                      <i class="fa-solid fa-check"></i>
                      <label class="carrito-product-title">Solicitud:</b></label>
                    </span>
                    <p class="carrito-product-description"><?php echo $item->solicitud ?></p>
                    <span>
                      <i class="fa-solid fa-check"></i>
                      <label class="carrito-product-title">Respuesta:</b></label>
                    </span>
                    <p class="carrito-product-description"><?php echo $item->respuesta ?></p>
                    <div class="d-flex align-items-center">
                      <span class="carrito-product-total">Total: <b>$<?php echo $item->monto_final ?></b></span>
                    </div>
                  </div>
                  <form method="POST" class="d-flex justify-content-end">
                    <input type="hidden" name="action" value="delete_item_carrito">
                    <input type="hidden" name="item_id" value="<?php echo $item->item_id ?>">
                    <button class="btn-delete-item-carrito btn btn-danger">Eliminar <i class="fa-solid fa-trash"></i></button>
                  </form>
                </div>
              </article>
            <?php
          }
        endforeach; 
      ?>
    </div>
  </div>

  <div class="col-md-6">
    <!-- TABS -->
    <ul class="nav nav-tabs hidden" id="myTab" role="tablist">
      <li class="nav-item" role="informacion">
        <button class="nav-link active" id="informacion-tab" data-bs-toggle="tab" data-bs-target="#informacion-tab-pane" type="button" role="tab" aria-controls="informacion-tab-pane" aria-selected="true">Informacion</button>
      </li>
      <li class="nav-item" role="pasarela">
        <button class="nav-link" id="pasarela-tab" data-bs-toggle="tab" data-bs-target="#pasarela-tab-pane" type="button" role="tab" aria-controls="pasarela-tab-pane" aria-selected="false">Pasarela</button>
      </li>
    </ul>
    <?php 
      include "../views/templates/alertas.php";
    ?>
    <div class="tab-content carrito-informacion" id="myTabContent">
      <!-- CONTENIDO DE INFORMACION -->
      <div class="tab-pane fade <?php echo ($userWereRegistering || !$userHasBeenRegistered) ? 'show active' : '' ?>" id="informacion-tab-pane" role="tabpanel" aria-labelledby="informacion-tab" tabindex="0">
        <h2 class="d-flex justify-content-between fw-bold next">Información del Pedido: 
          <b class="fw-bold">
            Total: 
            <?php 
              $acum = 0;
              foreach($carrito as $item){  
                $acum += $item->isCotizacion ? $item->monto_final : $item->total;
              }
              echo $acum;
            ?>$
          </b></h2>
        <div class="d-flex flex-column">
          <?php 
            if(count($carrito)<=0):
          ?>
            <h2>Nada por aquí...</h2>
          <?php
            endif;
            foreach($carrito as $item):
              if(!$item->isCotizacion){
          ?>
            <span class="carrito-informacion-item">
              <span>
                <i class="fa-solid fa-check"></i>
                <b><?php echo $item->categoria->nombre ?></b>
                <?php echo $item->item_id ?> 
              </span>
              <b><?php echo $item->total ?>$</b>
            </span>
          <?php 
              }else{
                ?>
                  <span class="carrito-informacion-item">
                    <span>
                      <i class="fa-solid fa-check"></i>
                      <b>Cotización</b>
                      <?php echo $item->item_id ?> 
                    </span>
                    <b><?php echo $item->monto_final ?>$</b>
                  </span>
                <?php
              }
            endforeach;
          ?>
          <hr class="my-1">
          <div class="d-flex justify-content-start mt-2">
            <input type="button" class="btn-realizar-pago btn-phantom-morado" value="Realizar Pago" <?php echo (count($carrito) == 0) ? 'disabled' : ''  ?>>
            <a class="btn-add-more" href="/dashboard">Añadir más Productos</a>
          </div>
        </div>
      </div>
      <!-- CONTENIDO DE LA PASARELA -->
      <div class="tab-pane fade <?php echo ($userWereRegistering || $userHasBeenRegistered) ? 'show active' : '' ?>" id="pasarela-tab-pane" role="tabpanel" aria-labelledby="pasarela-tab" tabindex="0">

        <ul class="nav nav-tabs hidden" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="registro-tab" data-bs-toggle="tab" data-bs-target="#registro-tab-pane" type="button" role="tab" aria-controls="registro-tab-pane" aria-selected="true">Culminar Registro</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link " id="pago-tab" data-bs-toggle="tab" data-bs-target="#pago-tab-pane" type="button" role="tab" aria-controls="pago-tab-pane" aria-selected="false">Realizar Pago</button>
          </li>
        </ul>

        <div class="tab-content" id="myTabContent">
          <!-- Contenido del Culminar Registro -->
          <div class="tab-pane fade <?php echo !$userCanBuy ? 'show active' : '' ?>" id="registro-tab-pane" role="tabpanel" aria-labelledby="registro-tab" tabindex="0">
            <h2 class="fw-bold mb-1">Culmina Tu Registro</h2>
            <p class="mb-0 text-secondary">Es necesario que culmines tu registro para poder realizar un pago.</p>
            <p class="text-secondary">Recuerda que estos datos son privados y solo serán usados para confirmar tu identidad.</p>
            <form method="POST">
              <input type="hidden" name="action" value="culminar_registro">
              <input type="hidden" name="id" value="<?php echo $user->id ?>">
              <input type="hidden" name="nombre" value="<?php echo $user->nombre ?>">
              <input type="hidden" name="apellido" value="<?php echo $user->apellido ?>">
              <input type="hidden" name="correo" value="<?php echo $user->correo ?>">
              <input type="hidden" name="clave" value="<?php echo $user->clave ?>">
              <div class="row">
                <div class="col-sm-6 col-12">
                  <label for="" class="mb-0">Direccion</label>
                  <input type="text" name="direccion" class="form-control" value="<?php echo $user->direccion ?>">
                </div>
                <div class="col-sm-6 col-12">
                  <label for="" class="mb-0">Número Celular</label>
                  <input type="text" name="telefono_celular" class="form-control" value="<?php echo $user->telefono_celular ?>">
                </div>
                <div class="col-sm-6 col-12">
                  <label for="" class="mb-0">Telefono Fijo</label>
                  <input type="text" name="telefono_fijo" class="form-control" value="<?php echo $user->telefono_fijo ?>">
                </div>
                <div class="col-sm-6 col-12">
                  <label for="" class="mb-0">Numero de Documento</label>
                  <input type="text" name="numero_documento" class="form-control soloLetras" value="<?php echo $user->numero_documento ?>">
                </div>
                <div class="col-sm-6 col-12">
                  <label for="" class="mb-0">Tipo de Documento</label>
                  <select name="id_tipo_documento" class="form-control">
                    <option value="1" selected>Cedula</option>
                  </select>
                </div>
                <div class="col-sm-6 col-12">
                  <label for="" class="mb-0">País</label>
                  <select name="id_pais" class="form-control">
                    <option value="1" selected>Pais de prueba</option>
                  </select>
                </div>
                <div class="col-sm-6 col-12">
                  <label for="" class="mb-0">Estado</label>
                  <select name="id_estado" class="form-control">
                    <option value="1" selected>Estado de Prueba</option>
                  </select>
                </div>
                <div class="col-sm-6 col-12">
                  <label for="" class="mb-0">Ciudad</label>
                  <select name="id_ciudad" class="form-control">
                    <option value="1" selected>Ciudad de Prueba</option>
                  </select>
                </div>
              </div>
              <div class="d-flex align-items-end justify-content-between">
                <a class="btn-back-carrito-informacion text-primary pointer"><i class="fa-solid fa-arrow-left"></i> Volver a Información</a>
                <input class="btn-phantom-morado mt-3" type="submit" value="Finalizar Registro">
              </div>
            </form>
          </div>
          <!-- Contenido de Realizar el pago -->
          <div class="tab-pane fade <?php echo ($userCanBuy || $userHasBeenRegistered) ? 'show active' : '' ?>" id="pago-tab-pane" role="tabpanel" aria-labelledby="pago-tab" tabindex="0">
            <h2 class="fw-bold mb-1">Culminar Pago</h2>
            <p class="mb-0 text-secondary">Selecciona el método de tu preferencia, rellena los datos y ¡todo listo!</p>
            <p class="mb-3 text-secondary">Tu pago sera procesado por uno de nuestros administradores, recibiras respuesta en un plazo de 2-5 días hábiles.</p>

            <ul class="nav nav-tabs pagar-tabs mb-3" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="transferencia-tab" data-bs-toggle="tab" data-bs-target="#transferencia-tab-pane" type="button" role="tab" aria-controls="transferencia-tab-pane" aria-selected="true">Transferencia</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="efectivo-tab" data-bs-toggle="tab" data-bs-target="#efectivo-tab-pane" type="button" role="tab" aria-controls="efectivo-tab-pane" aria-selected="false">Efectivo</button>
              </li>
            </ul>
            <div class="tab-content" id="myTabContent">
              <!-- Contenido para transferencia -->
              <div class="tab-pane fade show active" id="transferencia-tab-pane" role="tabpanel" aria-labelledby="transferencia-tab" tabindex="0">
                <form method="POST" enctype="multipart/form-data">
                  <input type="hidden" name="action" value="realizar_pago">
                  <input type="hidden" name="carrito" value='<?php echo json_encode($carrito) ?>'>
                  <input type="hidden" name="monto" value='<?php echo $acum ?>'>
                  <input type="hidden" name="id_tipo_pago" value='1'>
                    <b class="mt-3 mb-2">Total a cancelar: <?php echo $acum ?>$ (Al cambio del día)</b>
                    <p class="mt-3 mb-0"><b class="mt-3">Cancelar a la siguiente cuenta:</b></p>
                    <p class="text-secondary m-0"><b>Tlf: </b>0414-5598216</p>
                    <p class="text-secondary m-0"><b>C.I: </b>28.150.010</p>
                    <p class="text-secondary m-0 mb-3"><b>Banco: </b>Banesco Banco Universal</p>
                    <div class="row">
                      <div class="col-sm-6 col-12 mb-2">
                        <label for="" class="mb-0">Nro. Referencia de la transferencia:</label>
                        <input type="text" name="referencia" class="form-control soloNumeros" placeholder="Referencia:">
                      </div>
                      <div class="col-sm-6 col-12 mb-2">
                        <label for="" class="mb-0">Documento del Titular de la cuenta:</label>
                        <input type="text" name="numero_documento" class="form-control soloNumeros" placeholder="Nro. Documento:">
                      </div>
                      <div class="col-12">
                        <label for="image" class="mb-0">Comprobante/Imagen de la Transferencia:</label>
                        <input type="file" name="file" class="form-control" accept="image/png, image/gif, image/jpeg, image, images">
                      </div>
                    </div>

                  <div class="d-flex align-items-end justify-content-between">
                    <a class="btn-back-carrito-informacion text-primary pointer"><i class="fa-solid fa-arrow-left"></i> Volver a Información</a>
                    <input class="btn-phantom-morado mt-3" type="submit" value="Pagar">
                  </div>
                </form>
              </div>
              <!-- Contenido para efectivo -->
              <div class="tab-pane fade" id="efectivo-tab-pane" role="tabpanel" aria-labelledby="efectivo-tab" tabindex="0">
                <form method="POST">
                  <input type="hidden" name="action" value="realizar_pago">
                  <input type="hidden" name="carrito" value='<?php echo json_encode($carrito) ?>'>
                  <input type="hidden" name="id_tipo_pago" value='4'>
                  <input type="hidden" name="monto" value='<?php echo $acum ?>'>
                  <b class="mt-3 mb-2">Total a cancelar: <?php echo $acum ?>$ (Al cambio del día o en $ efectivo)</b>
                  <p class="mt-3 mb-0"><b class="mt-3">Si haces click en pagar, uno de nuestros administradores se pondrá en contacto contigo para poder retirar los dolares en efectivo, se comunicaran en un plazo de 1 a 2 días hábiles.</b></p>
                  <div class="d-flex align-items-end justify-content-between">
                    <a class="btn-back-carrito-informacion text-primary pointer"><i class="fa-solid fa-arrow-left"></i> Volver a Información</a>
                    <input class="btn-phantom-morado mt-3" type="submit" value="Pagar">
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>