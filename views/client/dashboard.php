<div class="jg-accordion-service-container flex-column flex-md-row align-items-md-start align-items-center">
  <?php 
    // echo json_encode($servicios);
    for($i = 0; $i<count($servicios);$i++){
      if(count($servicios[$i]->productos)>0){
  ?>
    <div class="accordion jg-accordion-service me-md-3 me-none my-3 my-md-none" id="servicio<?php echo $servicios[$i]->categoria->id ?>">
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $servicios[$i]->categoria->id ?>" aria-expanded="true" aria-controls="collapse<?php echo $servicios[$i]->categoria->id ?>">
            <span class="jg-service-title"><?php echo $servicios[$i]->categoria->nombre ?></span>
            <img src="/build/img/rrss.png" alt="">
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



  <!-- <div class="accordion jg-accordion-service me-md-3 me-none my-3 my-md-none" id="servicio2">
    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <span class="jg-service-title">Titulo del Servicio</span>
          <img src="/build/img/diseño.png" alt="">
        </button>
      </h2>
      <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#servicio2">
        <div class="accordion-body">
          <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
        </div>
      </div>
    </div>
  </div>
  <div class="accordion jg-accordion-service me-md-3 me-none my-3 my-md-none" id="servicio3">
    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
          <span class="jg-service-title">Titulo del Servicio</span>
          <img src="/build/img/diseño-web.png" alt="">
        </button>
      </h2>
      <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#servicio3">
        <div class="accordion-body">
          <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
        </div>
      </div>
    </div>
  </div> -->
</div>