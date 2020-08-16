<div class="row">
    <div class="col-12">


        <div class="card mb-5">
            <div class="card-header">
                <h4>Sucursales</h4>
                <a href="#" class="btn btn-primary btn-sm" id="newSucursal" data-toggle="modal" data-target="#AddSucursalModal" data-toggle="tooltip" data-placement="bottom" title="Agregar Nueva Sucursal">Nuevo</a>
                <a href="#" id="btnRefrescarSucursal" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="bottom" title="Refrescar Productos">Refrescar</a>
            </div>
            <!-- <pre>
          
          <?php //print_r($products) 
            ?>
          </pre> -->
            <div class="card-body">

                <div class="sucursalTable" id="sucursalTable">
                    <?php include_once(self::element('sucursal/sucursalTable')) ?>
                </div>
            </div>
        </div>
    </div>
</div>