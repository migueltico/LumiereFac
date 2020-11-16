<div class="col-lg-8 col-md-8 col-sm-12">
    <div class="card mb-5 shadow ">
        <div class="card-header">
            <h4>Impresion de etiquetas</h4>


            <a href="#" id="newQueque" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="bottom" title="Nueva Cola de impresion">Nueva Cola de impresion</a>
            <a href="#" id="loadDataProduct" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="bottom" title="Gargar Productos seleccionados">Gargar Productos seleccionados</a>
            <a href="#" id="makePdfPrint" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="bottom" title="Generar PDF">Generar PDF</a>
            <!-- <a href="/reportes/etiquetas" id="makePdfPrint1" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="bottom" title="Generar PDF">Generar PDF</a> -->
            <!-- <div class="row">
            <div class="input-group mb-3 col-lg-6 col-md-8 col-sm-12 mt-3">
                <input type="text" autocomplete="off" class="form-control" id="clientes_Search" placeholder="Buscar Cliente">
                <div class="input-group-append">
                </div>
            </div>
        </div> -->
        </div>
        <div class="card-body loadTable">

            <div class="table-responsive">
                <div class="urlPagination" data-url="/inventario/refresh/producttable">
                </div>
                <table class="table sort" id="sortable">
                    <thead>
                        <tr>
                            <th data-type="1" data-inner="0" scope="col" style="text-align: left;">Codigo</th>
                            <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Producto</th>
                            <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Estilo</th>
                            <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Talla</th>
                            <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Cant. Etiquetas</th>
                        </tr>
                    </thead>
                    <tbody data-sorts="DESC" id="tbodyPrint">
                       
                    </tbody>
                </table>
            </div>



        </div>

    </div>
</div>