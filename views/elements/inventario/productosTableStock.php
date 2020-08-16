<div class="table-responsive">

    <table class="table sort" id="sortable">
        <thead>
            <tr>
                <th data-type="1" data-inner="0" scope="col" style="text-align: center;">ID</th>
                <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Imagen</th>
                <th data-type="0" data-inner="0" scope="col">Descripcion</th>
                <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Talla</th>
                <th data-type="1" data-inner="1" scope="col" style="text-align: center;">Precio Unitario</th>
                <th data-type="1" data-inner="1" scope="col" style="text-align: center;">Precio Costo</th>
                <th data-type="1" data-inner="1" scope="col" style="text-align: left;">Precio Sugerido</th>
                <th data-type="1" data-inner="1" scope="col" style="text-align: center;">Precio</th>
                <th data-type="1" data-inner="0" scope="col" style="text-align: center;">Min. Stock</th>
                <th data-type="1" data-inner="0" scope="col" style="text-align: center;">Stock</th>
                <th data-type="1" data-inner="0" scope="col" style="text-align: center;">Accion</th>
            </tr>
        </thead>
        <tbody data-sorts="DESC">
            <?php
            $gravado = array("noGravado", "gravado");
            $estado = array("inhabilitado", "habilitado");
            ?>
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
                    <td scope="row" style="text-align: center;"><strong><?= $product["talla"] ?></strong></td>
                    <td scope="row" style="text-align: center;margin:0 auto;min-width: 175px !important;">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text inputWithStockBtn2">₡</span>
                            </div>
                            <input type="text" class="form-control inputWithStock" data-number="<?= $product['precio_unitario'] ?>" id="unitario_<?= $product["idproducto"] ?>" value="<?= $product["precio_unitario"] ?>">
                        </div>
                    </td>
                    <td scope="row" style="text-align: center;margin:0 auto;min-width: 175px !important;">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text inputWithStockBtn2">$</span>
                            </div>
                            <input type="text" class="form-control inputWithStock" data-number="<?= $product['precio_costo'] ?>" id="costo_<?= $product["idproducto"] ?>" value="<?= $product["precio_costo"] ?>">
                        </div>
                    </td>
                    <td scope="row" class="strongSugerido">
                        <strong id="sugerido_<?= $product["idproducto"] ?>" data-value="<?= $product["precio_sugerido"] ?>">
                            <?= $product["precio_sugerido"] ?>
                        </strong>
                        <button class="ml-3 btn btn-outline-info BtnCalcularSugerido  btn-sm" data-id="<?= $product["idproducto"] ?>"><?= $icons['update'] ?></button>

                    </td>
                    <td scope="row" data-value="<?= $product["precio_venta"] ?>" style="text-align: center;margin:0 auto;min-width: 175px !important;">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text inputWithStockBtn2">₡</span>
                            </div>
                            <input type="text" class="form-control inputWithStock" data-number="<?= $product['precio_venta'] ?>" id="precioVenta_<?= $product["idproducto"] ?>" value="<?= $product["precio_venta"] ?>">
                        </div>
                    </td>
                    <td scope="row" style="font-size:1.2rem" class="itemLeftData"><strong><?= $product["min_stock"] ?> </strong> <button  id="btnAddMinStock_<?= $product["idproducto"] ?>" class="ml-2  btn btn-sm btn-outline-primary addStockMinBtn itemLeftDataBtn"><?= $icons['plus'] ?></button></td>
                    <td scope="row" style="font-size:1.2rem" class="itemLeftData"><strong class="<?= ($product["stock"] <= $product["min_stock"] ? "text-danger" : "text-success") ?>"><?= $product["stock"] ?> </strong> <button class="itemLeftDataBtn ml-2 btn btn-sm btn-outline-primary addStockBtn" data-id="<?= $product["idproducto"] ?>" id="btnAddStock_<?= $product["idproducto"] ?>"><?= $icons['plus'] ?></button></td>
                    <td scope="row">
                        <div class="btn-group Editbuttons" aria-label="Grupo edicion">
                            <button type="button" class="btn btn-primary btnSaveProductPrice" id="btnSaveProductPrice<?= $product["idproducto"] ?>" data-id='<?= $product["idproducto"] ?>'><?= $icons['save'] ?> Guardar</button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>