<h1>Proyectos</h1>
<div class="container-fluid proyectos-container">
  <div class="table-responsive">
    <table class="table table-striped jambo_table bulk_action">
      <thead>
        <tr class="headings">
          <th class="column-title">Id</th>
          <th class="column-title">Nombre</th>
          <th class="column-title">Estado</th>
          <th class="column-title">Categoria</th>
          <th class="column-title">Fecha de Creación</th>
          <!-- <th class="bulk-actions" colspan="7">
            <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
          </th> -->
        </tr>
      </thead>

      <tbody>
        <?php
          for($i = 0;$i<count($proyectos);$i++){
            ?>
              <tr class="<?php echo ($i % 2 == 0) ? 'even' : 'odd' ?> pointer">
                <td class=" "><?php echo $proyectos[$i]->id; ?></td>
                <td class=" "><?php echo $proyectos[$i]->nombre; ?></td>
                <td class=" "><?php echo $proyectos[$i]->estado; ?></td>
                <td class=" "><?php echo $proyectos[$i]->categoria->nombre; ?></td>
                <td class=" "><?php echo $proyectos[$i]->fecha; ?></td>
              </tr>
            <?php
          }
        ?>
      </tbody>
    </table>
  </div>
</div>