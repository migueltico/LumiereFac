<?php
$gravado = array("noGravado", "gravado");
$estado = array("inhabilitado", "habilitado");
$generator = new Picqer\Barcode\BarcodeGeneratorSVG();
$maxpage = $paginationInfo['paginacion']['paginas'];
?>
<div class="table-responsive">
<div class="urlPagination" data-url="/inventario/refresh/producttable">
  <?php include(self::block('pagination')) ?>
</div>
  <p>Total de productos: <?=$paginationInfo['cantidad']?></p>
  <table class="table sort" id="sortable">
    <thead>
      <tr>
        <th data-type="1" data-inner="0" scope="col" style="text-align: center;">ID</th>
        <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Imagen</th>
        <th data-type="0" data-inner="0" scope="col">Descripcion</th>
        <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Codigo</th>
        <th data-type="0" data-inner="0" scope="col">Categoria</th>
        <th data-type="0" data-inner="0" scope="col">Marca</th>
        <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Estilo</th>
        <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Talla</th>
        <th data-type="1" data-inner="1" scope="col" style="text-align: center;">IVA</th>
        <th data-type="1" data-inner="1" scope="col" style="text-align: center;">Precio</th>
        <th data-type="1" data-inner="0" scope="col" style="text-align: center;">Stock</th>
        <th data-type="0" data-inner="0" scope="col" style="text-align: center;">fecha modificacion</th>
        <th data-type="0" data-inner="1" scope="col">Activado</th>
        <th data-type="0" data-inner="0" scope="col">Acciones</th>
      </tr>
    </thead>
    <tbody data-sorts="DESC">

      <!-- <span class="mr-2"><?php //echo$icons["codebar"] 
                              ?></span> -->
      <?php foreach ($products as $product) : ?>
        <?php
        $urls = explode(",", $product['image_url']);
        ?>
        <?php $newDate = date("d-M-y", strtotime($product["ultima_modificacion"])); ?>
        <tr class="TrRow">
          <td scope="row" style="text-align: center;"><?= $product["idproducto"] ?></td>
          <td scope="row" style="text-align: center;">
            <div id="imgsf-<?= $product["idproducto"] ?>" class="tooltipimgView imgProductGallery">
              <?php if ($urls[0] !== '') : ?>
                <img src="<?= $urls[0] ?>">
              <?php else : ?>
                <img src="/public/assets/img/not-found.png">
              <?php endif; ?>
            </div>
          </td>
          <td scope="row"><?= $product["descripcion"] ?></td>
          <!-- <td scope="row" style="text-align: center;"><?// $product["codigo"] ?></td> -->
          <td scope="row" style="text-align: center;">
            <div class="codebarsHtml" style="text-align: center;">
              <?php //echo '<img width="150px" src="data:image/png;base64,' . base64_encode($generator->getBarcode($product["codigo"], $generator::TYPE_CODE_128)) . '">' 
              ?>
              <?php echo $generator->getBarcode($product["codigo"], $generator::TYPE_CODE_128); ?>
            </div>
            <p><?= $product["codigo"] ?></p>

          <td scope="row"><?= $product["categoria"] ?></td>
          <td scope="row"><?= $product["marca"] ?></td>
          <td scope="row" style="text-align: center;"><?= $product["estilo"] ?></td>
          <td scope="row" style="text-align: center;"><?= $product["talla"] ?></td>
          <td scope="row" data-value="<?= $product["activado_iva"] ?>" style="text-align: center;margin:0 auto">
            <div class="<?= $gravado[$product["activado_iva"]] ?>" data-toggle="tooltip" data-placement="top" title="<?= $product["iva"] . ' - ' . $product["activado_iva"] ?>"></div>
          </td>
          <td scope="row" data-value="<?= $product["precio_venta"] ?>" style="text-align: center;margin:0 auto"><strong><?= sprintf("%s " . number_format($product["precio_venta"], 2, '.', ','), "	₡") ?></strong></td>
          <td scope="row" style="text-align: center;margin:0 auto"><strong><?= $product["stock"] ?></strong></td>
          <td scope="row" style="text-align: center;"><?= $newDate ?></td>
          <td scope="row" data-value="<?= $product["estado"] ?>" data-toggle="tooltip" data-placement="top" title="">
            <div class="<?= $estado[$product["estado"]] ?>"></div>
          </td>
          <td scope="row">
            <div class="btn-group Editbuttons" aria-label="Grupo edicion">
              <button type="button" class="btn btn-success EditProductBtn" data-toggle="modal" data-target="#EditProduct" data-idProductEdit='<?= $product["idproducto"] ?>'><?= $icons['edit'] ?></button>
              <button type="button" class="btn btn-primary pl-3 pr-3 SeeImgProduct" data-urls="<?= $product["image_url"] ?>" data-toggle="modal" data-target="#galleryShow" data-name="<?= $product["descripcion"] ?>" data-idProductEdit='<?= $product["idproducto"] ?>'><?= $icons['eye'] ?></button>
              <button type="button" class="btn btn-info pl-3 pr-3 printToast" data-precio="<?= $product["precio_venta"] ?>" data-name="<?= $product["descripcion"] ?>" data-talla="<?= $product["talla"] ?>" data-estilo="<?= $product["estilo"] ?>" data-idProduct='<?= $product["codigo"] ?>'><?= $icons['print'] ?></button>
              <button type="button" class="btn btn-danger" data-idProductEdit='<?= $product["idproducto"] ?>'><?= $icons['trash'] ?></button>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<div class="urlPagination" data-url="/inventario/refresh/producttable">
<?php include(self::block('pagination')) ?>
</div>
