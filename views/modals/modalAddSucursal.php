<!-- Modal -->
<div class="modal fade" id="addProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <form id="AddSucursalForm" enctype="multipart/form-data" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Nueva Sucursal</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body row">
          <div class="row col-12">
            <div class="col-6">
              <div class="input-group input-group-sm mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="inputGroup-sizing-sm">Descripcion</span>
                </div>
                <input id="descripcion" type="text" name="descripcion" class="form-control  p-3" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" autofocus>
              </div>
            </div>
            <div class="col-3">
              <div class="input-group input-group-sm mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="inputGroup-sizing-sm">Ubicacion</span>
                </div>
                <input id="ubicacion" type="text" name="ubicacion" class="form-control  p-3" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
              </div>
            </div>
            <div class="col-3">
              <div class="input-group input-group-sm mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="inputGroup-sizing-sm">Telefono</span>
                </div>
                <input type="tel" name="telefono" class="form-control  p-3" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
              </div>
            </div>         
          </div>
        </div>
        <div class="modal-footer" id="btns_parsers">
          <button type="button" class="closeBtn btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button id="AddSucursalFormBtn" type="submit" class="btn btn-primary">Agregar S</button>
        </div>
      </div>
    </form>
  </div>
</div>