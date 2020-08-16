<div class="card mb-5 shadow">
    <div class="card-header">
        <h4>Stock y Precios</h4>
        <div class="row">
            <div class="input-group mb-3 col-lg-6 col-md-8 col-sm-12 mt-3">
                
                    <input autocomplete="off" type="text" class="form-control" id="productSearchStock" placeholder="Buscar Producto">
               
                <div class="input-group-append">
                    <!-- <button class="btn btn-outline-secondary" type="button" id="button-addon2">Buscar</button> -->
                </div>
            </div>
        </div>
    </div>
    <div class="card-body loadTable">
        <?php include(self::element('inventario/productosTableStock')) ?>
    </div>

</div>