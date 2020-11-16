<div class="card mb-5 shadow">
    <div class="card-header">
        <h4>Facturas Pendientes</h4>

        <a href="#" class="btn btn-primary btn-sm" id="clientes_newProduct" data-toggle="modal" data-target="#clientes_addCliente" data-toggle="tooltip" data-placement="bottom" title="Agregar Nuevo Cliente"><?= $icons['plus-circle'] ?> Nuevo</a>
        <a href="#" id="clientes_RefreshClientes" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="bottom" title="Refrescar Clientes">Refrescar</a>
    
    </div>
    <div class="card-body loadTable">
        <?php include(self::element('facturacion/facturasTable')) ?>
    </div>

</div>
<?php include(self::modal('modalVerProductosPendientes')) ?>