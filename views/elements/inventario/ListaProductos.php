<div class="card mb-5 shadow">
  <div class="card-header">
    <h4>Productos</h4>
    <a href="#" class="btn btn-primary btn-sm" id="newProduct" data-toggle="modal" data-target="#addProduct" data-toggle="tooltip" data-placement="bottom" title="Agregar Nuevo producto">Nuevo</a>
    <a href="#" id="btnRefrescarProducto" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="bottom" title="Refrescar Productos">Refrescar</a>
  </div>
  <div class="card-body loadTable">
    <?php include(self::element('inventario/productosTable')) ?>
  </div>
  <?php include_once(self::element('inventario/allModals')) ?>

</div>