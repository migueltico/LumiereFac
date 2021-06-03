<div class="card mb-5 shadow">
  <div class="card-header">
    <h4>Productos</h4>
    <?php if (array_key_exists("inv_crear", $_SESSION['permisos'])) :  ?>    
      <a href="#" class="btn btn-primary btn-sm" id="newProduct" data-toggle="modal" data-target="#addProduct" data-toggle="tooltip" data-placement="bottom" title="Agregar Nuevo producto"><?= $icons['plus-circle'] ?> Nuevo</a>
    <?php endif;  ?>
    <a href="#" id="btnRefrescarProducto" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="bottom" title="Refrescar Productos">Refrescar</a>

    <label class="form-check-label ml-2" for="checkestado">
      Buscar Inactivos
    </label>
    <input class="form-check-input ml-3" type="checkbox" id="checkestado" value="">
    <div class="row">
      <div class="input-group mb-3 col-lg-6 col-md-8 col-sm-12 mt-3">
        <input type="text" autocomplete="off" class="form-control inputSearchPagination" id="productSearch" placeholder="Buscar Producto">
        <div class="input-group-append">
          <!-- <button class="btn btn-outline-secondary" type="button" id="button-addon2">Buscar</button> -->
        </div>
      </div>
    </div>
  </div>
  <div class="card-body loadTable">
    <?php include(self::element('inventario/productosTable')) ?>
  </div>
  <?php include_once(self::element('inventario/allModals')) ?>

</div>