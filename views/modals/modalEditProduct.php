<div class="modal fade" id="EditProduct" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editIdProducto">Editar Producto #</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="EditProductForm" class="display_flex_row" enctype="multipart/form-data" method="post">
        <input type="hidden" name="idproducto" id="EditProduct_idproducto">
        <div class="modal-body display_flex_row">
          <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <div class="col-12">
              <div class="input-group input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="inputGroup-sizing-sm">Descripcion</span>
                </div>
                <input type="text" id="EditProduct_descripcion" name="descripcion" class="form-control  p-3">
              </div>
            </div>
            <div class="col-12">
              <div class="input-group input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="inputGroup-sizing-sm">Descripcion Corta</span>
                </div>
                <input type="text" id="EditProduct_descripcion_short" maxlength="30"  placeholder="Max. 30 Caracteres"  name="descripcion_short" class="form-control  p-3">
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
              <div class="input-group input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="inputGroup-sizing-sm">Marca</span>
                </div>
                <input type="text" name="marca" class="form-control  p-3" id="EditProduct_marca">
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
              <div class="input-group input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="inputGroup-sizing-sm">Estilo</span>
                </div>
                <input type="text" name="estilo" class="form-control  p-3" id="EditProduct_estilo">
              </div>
            </div>

            <div class="col-12">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <label class="input-group-text" for="EditProduct_cbCategoria">Categoria</label>
                </div>
                <select name="categoria" class="custom-select" id="EditProduct_cbCategoria">
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
                  <label class="input-group-text" for="EditProduct_cbCategoriaPrecio">Categoria de precio</label>
                </div>
                <select name="categoriaPrecio" class="custom-select" id="EditProduct_cbCategoriaPrecio">
                  <option selected value="0">Seleccione una Categoria...</option>
                  <?php foreach ($cat_precios as $cat_precio) : ?>
                    <?php if ($_SESSION["idrol"] == 1) : ?>
                      <option value="<?= $cat_precio['idCategoriaPrecio'] ?>"><?= $cat_precio['descripcion'] ?> ( <?= $cat_precio['factor'] ?> )</option>
                    <?php else : ?>
                      <option value="<?= $cat_precio['idCategoriaPrecio'] ?>"><?= $cat_precio['descripcion'] ?></option>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="col-12">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <label class="input-group-text" for="EditProduct_cbDescuento">Descuento</label>
                </div>
                <select name="descuento" class="custom-select" id="EditProduct_cbDescuento">
                  <option selected value="0">N/A</option>
                  <?php foreach ($descuentos as $descuento) : ?>
                    <?php if ($descuento['iddescuento'] !== 0) : ?>
                      <option value="<?= $descuento['iddescuento'] ?>"><?= $descuento['descripcion'] ?> (<?= $descuento['descuento'] ?>%)</option>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="col-12">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <label class="input-group-text" for="EditProduct_cbTalla">Talla</label>
                </div>
                <select name="talla" class="custom-select" id="EditProduct_cbTalla">
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
                    <input id="EditProduct_iva" name="iva" type="checkbox" data-toggle="tooltip" data-placement="top" title="IVA %">
                  </div>
                </div>
                <input name="iva_valor" id="EditProduct_iva_valor" type="text" class="form-control  p-3" placeholder="IVA %" data-toggle="tooltip" data-placement="top" title="IVA %">
              </div>
            </div>
            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <button class="btn btn-secondary" type="button" id="EditProduct_generarCodigo">Generar</button>
                </div>
                <input id="EditProduct_txtcodigoBarra" name="codigoBarras" type="text" class="form-control" placeholder="Codigo de barras" autocomplete="false" data-toggle="tooltip" data-placement="top" title="Codigo de barras">
              </div>
            </div>
            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 form-group">
              <div class="custom-control custom-switch">
                <input type="checkbox" name="estado" class="custom-control-input" id="EditProduct_editEstadoCheck" checked="">
                <label class="custom-control-label" for="EditProduct_editEstadoCheck">Activado</label>
              </div>
            </div>
            <div id="inputtFile" class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="EditProduct_files01">Upload</span>
                </div>
                <div class="custom-file">
                  <input type="file" multiple class="custom-file-input" id="EditProduct_filesImages" accept="image/gif, image/jpeg, image/png">
                  <label class="custom-file-label" for="EditProduct_filesImages">Choose file</label>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <input type="file" name="file[]" multiple id="EditProduct_filesImageHidden" hidden accept="image/gif, image/jpeg, image/png">
            <div id="EditProduct_imageContainer" class="col-md-12 imgWrapperContainer">
            </div>
          </div>
        </div>
      </form>
      <div class="modal-footer">
        <button type="button" class="closeBtn btn btn-secondary edit" data-dismiss="modal">Cerrar</button>
        <button id="EditProductFormBtn" type="submit" class="btn btn-primary edit">Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>