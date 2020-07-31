<div class="row">
    <div class="col-12">
        <?php include_once(self::modal('modalAddSucursal')) ?>

        <div class="card mb-5">
            <div class="card-header">
                <h4>Sucursales</h4>
                <a href="#" class="btn btn-primary btn-sm" id="newProduct" data-toggle="modal" data-target="#addProduct" data-toggle="tooltip" data-placement="bottom" title="Agregar Nuevo producto">Nuevo</a>
                <a href="#" id="btnRefrescarProducto" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="bottom" title="Refrescar Productos">Refrescar</a>
            </div>
            <!-- <pre>
          
          <?php //print_r($products) 
            ?>
          </pre> -->
            <div class="card-body">

                <div id="productTable">
                    <?php include_once(self::element('sucursalTable')) ?>
                </div>
            </div>
        </div>
    </div>  
</div>