<div class="card mb-5 shadow">
    <div class="card-header">
        <h4>Descuentos por Lote</h4>
        <div class="row">
            <div class="input-group mb-3 col-lg-6 col-md-8 col-sm-12 mt-3">
                <button class="btn btn-info" id="buscarProductoBtn">Buscar Productos</button>
            </div>
        </div>
    </div>
    <div class="card-body loadTable">
        <hr>
        <div class="row mb-3">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">Descuento</label>
                    </div>
                    <select class="custom-select" id="iddescuentoSelect">
                        <option selected disabled value="0">Seleccione un descuento</option>
                        <?php foreach ($data as $desc) :  ?>
                            <option value="<?= $desc['iddescuento'] ?>"><?= $desc['descripcion'] ?> (<?= $desc['descuento'] ?>%)</option>
                        <?php endforeach;  ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-3">
                <button class="btn btn-primary " id="aplicarDescuento">Aplicar Descuento por lote</button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table sort" id="sortable">
                <thead>
                    <tr>
                        <th data-type="1" data-inner="0" scope="col" style="text-align: center;">#Codigo</th>
                        <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Producto</th>
                        <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Marca</th>
                        <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Modelo</th>
                        <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Descuento Actual</th>
                        <th data-type="1" data-inner="0" scope="col" style="text-align: center;">Accion</th>
                    </tr>
                </thead>
                <tbody data-sorts="DESC" id="tbodyDescuentosPorlote">
                </tbody>
            </table>
        </div>
    </div>

</div>
<?php include(self::modal('modalSearchProductGeneral')) ?>