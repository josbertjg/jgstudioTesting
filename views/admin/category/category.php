<div class="col-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Agregar categoría de producto</h2>
            <ul class="navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php include "../views/templates/alertas.php"; ?>

            <form method="POST" class="form" enctype="multipart/form-data">
                <div class="row align-items-center">
                    <div class="col-sm-6 col-12">
                        <label for="">Nombre</label>
                        <input type="text" name="nombre" class="form-control">
                    </div>
                    <div class="col-sm-6 col-12" style="margin-top:2%;">
                        <input type="file" name="file"><br>
                    </div>
                    <input type="submit" value="Añadir" class="btn btn-primary col-12 mt-3">
                </div>
            </form>
        </div>
    </div>
</div>

<div class="col-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Listado de categorías</h2>
            <ul class="navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
                <table class="table table-striped jambotable bulkaction">
                    <thead>
                        <tr class="headings">
                            <th class="column-title">Nombre</th>
                            <th class="column-title">Imagen</th>
                            <th class="column-title">Estado</th>
                            <th class="column-title no-link last"><span class="nobr">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 0; $i < count($category); $i++) { ?>
                            <tr class="<?php echo ($i % 2 == 0) ? 'even' : 'odd' ?> pointer">
                                <td class=""><?php echo $category[$i]->nombre; ?></td>
                                <td class="">
                                    <picture>
                                        <source srcset="<?php echo $category[$i]->imagen; ?>" type="image/webp">
                                        <source srcset="<?php echo $category[$i]->imagen; ?>" type="image/png">
                                        <img class="" loading="lazy" width="100" height="100" src="<?php echo $category[$i]->imagen; ?>" alt="<?php echo $category[$i]->imagen; ?>">
                                    </picture>
                                </td>
                                <td class="a-right a-right "><?php echo ($category[$i]->estado == 1) ? 'Activo' : 'Inactivo' ?></td>
                                <td class=" last">
                                    <a href="/admin/category/categoryDetail?id=<?php echo $category[$i]->id ?>"><i class="fa-solid fa-eye btn btn-primary"></i></a>
                                    <button type="button" class="fa-solid fa-trash btn btn-danger" data-toggle="modal" data-target="#confirmar_modal" data-id="<?php echo $category[$i]->id ?>"></button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmar_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog justify-content-center" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Confirmar eliminación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Estás seguro que deseas eliminar este registro?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <form id="eliminar_form" action="/admin/delete" method="POST">
                    <input type="hidden" name="id" value="">
                    <button type="submit" class="btn btn-danger">Aceptar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#confirmar_modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('input[name="id"]').val(id);
        });

        $('#confirmar_modal').on('click', '.btn-danger', function (event) {
            event.preventDefault();
            $('#eliminar_form').submit();
        });
    });
</script>