<?php
$productos = json_decode($data['productos'], true);
?>
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
    <div class="col-12">
        <div class="input-group input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">Tienda Origen</span>
            </div>
            <input type="text" id="traslado_tienda_origen_detail" name="tiendaOrigen" class="form-control p-3" disabled value="<?= $data['tiendaOrigen']  ?>">
        </div>
    </div>
    <div class="col-12">
        <div class="input-group input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">Tienda Traslado</span>
            </div>
            <input type="text" id="traslado_tienda_traslado_detail" name="tiendaTraslado" class="form-control p-3" disabled value="<?= $data['tiendaTraslado']  ?>">
        </div>
    </div>
    <div class="col-12">
        <div>
            <label for="traslado_comentario_detail">Comentario</label>
        </div>
        <textarea name="comentario" id="traslado_comentario_detail" cols="50" rows="5" disabled style="padding: 5px;width:100%"><?= $data['comentario']  ?></textarea>
    </div>
</div>
<h3 class="text-center p-3">Lista de Productos</h3>
<div class="table-responsive" style="min-height: 230px;">
    <table class="table sort trasladoRowsTableDetail" data-class="trasladoRowsTableDetail" id="sortable">
        <thead>
            <tr>
                <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Codigo</th>
                <th data-type="0" data-inner="0" scope="col">Descripcion</th>
                <th data-type="0" data-inner="0" scope="col">Marca</th>
                <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Estilo</th>
                <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Talla</th>
                <th data-type="1" data-inner="1" scope="col" style="text-align: center;">Cantidad</th>
            </tr>
        </thead>
        <tbody id="trasladoRowsDetailsModal" data-sorts="DESC">
            <?php foreach ($productos as $producto) : ?>

                <tr class="TrRow" id="id_traslado_<?= $producto["codigo"] ?>">
                    <td scope="row" style="text-align: center;font-weight:bold"><?= $producto["codigo"] ?></td>
                    <td scope="row" style="text-align: center;"><?= $producto["descripcion"] ?></td>
                    <td scope="row" style="text-align: center;"><?= $producto["marca"] ?></td>
                    <td scope="row" style="text-align: center;"><?= $producto["estilo"] ?></td>
                    <td scope="row" style="text-align: center;"><?= $producto["talla"] ?></td>
                    <td scope="row" style="text-align: center;"><?= $producto["cantidad"]  ?></td>

                </tr>
            <?php endforeach; ?>

        </tbody>
    </table>
</div>