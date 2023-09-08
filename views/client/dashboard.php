<div class="jg-accordion-service-container flex-column flex-md-row align-items-md-start align-items-center">
  <?php 
    for($i = 0; $i<count($servicios);$i++){
      if(count($servicios[$i]->productos)>0){
  ?>
    <div class="accordion jg-accordion-service me-md-3 me-none my-3 my-md-none" id="servicio<?php echo $servicios[$i]->categoria->id ?>">
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $servicios[$i]->categoria->id ?>" aria-expanded="true" aria-controls="collapse<?php echo $servicios[$i]->categoria->id ?>">
            <span class="jg-service-title"><?php echo $servicios[$i]->categoria->nombre ?></span>
            <img src="<?php echo $servicios[$i]->categoria->imagen ?>" alt="<?php echo $servicios[$i]->categoria->nombre ?>">
          </button>
        </h2>
        <div id="collapse<?php echo $servicios[$i]->categoria->id ?>" class="accordion-collapse collapse" data-bs-parent="#servicio<?php echo $servicios[$i]->categoria->id ?>">
          <div class="accordion-body">
            <form method="POST">
              <?php foreach($servicios[$i]->productos as $producto){ ?>
                <label class="product-title">
                  <i class="fa-solid fa-check"></i>
                  <?php echo $producto->nombre ?> 
                  <b>$<?php echo $producto->precio_unitario ?></b>
                </label>
                <p class="product-description"><?php echo $producto->descripcion ?></p>
                <input 
                  type="hidden" 
                  class="producto-<?php echo $producto->id ?>" 
                  name="producto-<?php echo $producto->id ?>" 
                  value='<?php 
                    $objeto = (object)[];
                    $objeto->id_categoria = $servicios[$i]->categoria->id;
                    $objeto->imagen_categoria = $servicios[$i]->categoria->imagen;
                    $objeto->nombre_categoria = $servicios[$i]->categoria->nombre;
                    $objeto->id_producto = $producto->id;
                    $objeto->nombre_producto = $producto->nombre;
                    $objeto->cantidad_producto = 0;
                    $objeto->item_id = uniqid();
                    echo json_encode($objeto)
                  ?>'
                >
                <?php if($producto->cantidad_maxima>1){ ?>
                <div class="product-input d-flex align-items-center">
                  <label class="product-input-title">Cantidad:</label>
                  <input 
                    cantidad_maxima="<?php echo $producto->cantidad_maxima ?>" 
                    precio="<?php echo $producto->precio_unitario ?>" 
                    producto_id="<?php echo $producto->id ?>"  
                    categoria_id="<?php echo $servicios[$i]->categoria->id ?>"
                    class="form-control producto producto-categoria-<?php echo $servicios[$i]->categoria->id ?> product-input-text" 
                    type="number" 
                    value="0"
                  >
                </div>
                <?php }else{ ?>
                <div class="form-check form-switch product-input">
                  <input 
                    class="form-check-input producto producto-categoria-<?php echo $servicios[$i]->categoria->id ?>" 
                    type="checkbox" 
                    role="switch" 
                    id="checkbox-producto-<?php echo $producto->id ?>" 
                    cantidad_maxima="<?php echo $producto->cantidad_maxima ?>" 
                    precio="<?php echo $producto->precio_unitario ?>" 
                    producto_id="<?php echo $producto->id ?>"
                    categoria_id="<?php echo $servicios[$i]->categoria->id ?>"
                  >
                  <label class="form-check-label product-input-title" for="checkbox-producto-<?php echo $producto->id ?>">Añadir <?php echo $producto->nombre ?>?</label>
                </div>
                <?php } 
                } ?>
                <hr class="mb-1">
                <div class="jg-service-total">
                  <span>Total: </span>
                  <span> $ <span class="total total-<?php echo $servicios[$i]->categoria->id ?>">0.00</span></span>
                </div>
              <input type="submit" class="btn btn-warning btn-block add-carrito-<?php echo $servicios[$i]->categoria->id ?>" value="Añadir al Carrito" disabled="true">
            </form>
          </div>
        </div>
      </div>
    </div>
  <?php
      }
    }
  ?>

</div>
<div class="jg-cotizacion-container flex-md-row flex-column">
  <div>
    <h5>¿No encontraste lo que buscabas?, ¡Tranquilo!</h5>
    <h1>Cotización</h1>
    <p><b>Escríbenos</b> un mensaje solicitándonos lo que necesitas y te <b>responderemos</b> lo mas pronto posible! </p>
    <input type="hidden" class="jg-alert" value='<?php echo json_encode($alertas) ?>'>
    <form method="POST">
      <?php
        // include "../views/templates/alertas.php";
      ?>
      <input type="hidden" name="action" value="cotizacion">
      <input type="hidden" name="id_usuario" value="<?php echo currentUser_id(); ?>">
      <textarea class="form-control" name="solicitud" cols="10" rows="6" placeholder="Mensaje:"></textarea>
      <input type="submit" class="btn-submit mt-3" value="Enviar Solicitud">
    </form>
  </div>
  <img src="build/img/cotizacion-form.png" alt="cotizacion jgstudio">
</div>
