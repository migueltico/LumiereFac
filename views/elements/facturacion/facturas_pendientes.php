<div class="card mb-5 shadow">
    <div class="card-header">
        <h4>Facturas Pendientes</h4>
    </div>
    <div class="card-body loadTable">
        <?php include(self::element('facturacion/facturasTable')) ?>
    </div>

</div>
<?php include(self::modal('modalVerProductosPendientes')) ?>