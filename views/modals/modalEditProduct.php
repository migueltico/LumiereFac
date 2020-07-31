
<div class="modal fade" id="EditProduct" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editIdProducto">Agregar Nuevo Producto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="EditProductForm" class="display_flex_row" enctype="multipart/form-data" method="post">
        <div class="modal-body display_flex_row">
          <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <div class="col-12">
              <div class="input-group input-group-sm mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="inputGroup-sizing-sm">Descripcion</span>
                </div>
                <input type="text" id="descripcion" name="descripcion" class="form-control  p-3">
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
              <div class="input-group input-group-sm mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="inputGroup-sizing-sm">Marca</span>
                </div>
                <input type="text" name="marca" class="form-control  p-3" id="marca">
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
              <div class="input-group input-group-sm mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="inputGroup-sizing-sm">Estilo</span>
                </div>
                <input type="text" name="estilo" class="form-control  p-3" id="estilo">
              </div>
            </div>

            <div class="col-12">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <label class="input-group-text" for="cbCategoria">Categoria</label>
                </div>
                <select name="categoria" class="custom-select" id="cbCategoria">
                  <option selected value="0">Seleccione una Categoria...</option>
                  <?php foreach ($categorias as $categoria) : ?>
                    <option value="<?= $categoria['idcategoria'] ?>"><?= $categoria['descripcion'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>

            <div class="col-12">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <label class="input-group-text" for="cbTalla">Talla</label>
                </div>
                <select name="talla" class="custom-select" id="cbTalla">
                  <option selected value="0">Seleccione una Talla...</option>
                  <?php foreach ($tallas as $talla) : ?>
                    <option value="<?= $talla['idtallas'] ?>"><?= ($talla['descripcion'] ==  $talla['talla'] ?  $talla['descripcion'] :  $talla['descripcion'] . " (" . $talla['talla'] . ")") ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <input id="iva" name="iva" type="checkbox" aria-label="Checkbox for following text input" data-toggle="tooltip" data-placement="top" title="IVA %">
                  </div>
                </div>
                <input name="iva_valor" id="iva_valor" type="text" class="form-control  p-3" aria-label="Text input with checkbox" placeholder="IVA %" data-toggle="tooltip" data-placement="top" title="IVA %">
              </div>
            </div>
            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <button class="btn btn-secondary" type="button" id="generarCodigo">Generar</button>
                </div>
                <input id="txtcodigoBarra" name="codigoBarras" type="text" class="form-control" placeholder="Codigo de barras" autocomplete="false" data-toggle="tooltip" data-placement="top" title="Codigo de barras">
              </div>
            </div>

            <div class="borderModal col-12 borderContainer">
              <?php foreach ($sucursal as $tienda) : ?>
                <div class="col-12">
                  <div class="custom-control custom-switch" id="ckSucursalesAdd">
                    <input type="checkbox" class="checkSucursal custom-control-input" id="idsucursal<?= $tienda["idsucursal"] ?>" <?= ($tienda["idsucursal"] == $_SESSION['idsucursal'] ? "checked" : "") ?> data-sucursal="<?= $tienda["idsucursal"] ?>">
                    <label class="custom-control-label" for="idsucursal<?= $tienda["idsucursal"] ?>"><?= $tienda["descripcion"] ?></label>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
            <div id="inputtFile" class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="files01">Upload</span>
                </div>
                <div class="custom-file">
                  <input type="file" multiple class="custom-file-input" id="filesImages" accept="image/gif, image/jpeg, image/png">
                  <label class="custom-file-label" for="files">Choose file</label>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <input type="file" name="file[]" multiple id="filesImageHidden" hidden accept="image/gif, image/jpeg, image/png">
            <div id="imageContainer" class="col-md-12 imgWrapperContainer">
            </div>
          </div>
        </div>
      </form>
      <div class="modal-footer">
      <button type="button" class="closeBtn btn btn-secondary edit" data-dismiss="modal">Cerrar</button>
      <button id="EditProductFormBtn" type="submit" class="btn btn-primary edit">Agregar</button>
      </div>
    </div>
  </div>
</div>