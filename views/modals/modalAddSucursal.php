<div class="modal" id="AddSucursalModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Nueva Sucursal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="AddSucursalForm" class="display_flex_row" enctype="multipart/form-data" method="post">
          <div class="modal-body display_flex_row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
              <div class="col-12">
                <div class="input-group input-group-sm mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Sucursal</span>
                  </div>
                  <input type="text" id="sucursal" name="sucursal" class="form-control  p-3">
                </div>
              </div>
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="input-group input-group-sm mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Ubicacion</span>
                  </div>
                  <input type="text" name="ubicacion" class="form-control  p-3" id="marca">
                </div>
              </div>
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="input-group input-group-sm mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Telefono</span>
                  </div>
                  <input type="text" name="tel" class="form-control  p-3" id="estilo">
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" id="btnAddSucursal" class="btn btn-primary">Agregar</button>
      </div>
    </div>
  </div>
</div>