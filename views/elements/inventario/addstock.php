<div class="card mb-5 shadow">
    <div class="card-header">
        <h4>Stock y Precios</h4>
        <div class="row">
            <div class="input-group mb-3 col-lg-6 col-md-8 col-sm-12 mt-3">

                <input autocomplete="off" type="text" class="form-control inputSearchPagination" id="productSearchStockInventario" placeholder="Buscar Producto">

                
            </div>
            <div class="col-2 input-group-append">
                    <label class="form-check-label mt-4" for="checkestado">
                        Buscar Inactivos
                    </label>
                    <input class="form-check-input mt-4" type="checkbox" id="checkestado" value="">

                </div>
        </div>
    </div>
    <div class="card-body loadTable">
        <?php include(self::element('inventario/productosTableStock')) ?>
    </div>

</div>