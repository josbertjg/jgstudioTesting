<?php
    foreach($alertas as $key => $alerta) {
        foreach($alerta as $mensaje) {
?>
    <div class="alert alert-<?php echo $key; ?> alert-dismissible " role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <strong><?php echo $mensaje; ?></strong>
    </div>
<?php
    }
}
?>