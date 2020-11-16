<table class="table sort" id="sortable">
    <thead>
        <tr>
            <th data-type="1" data-inner="0" scope="col" style="text-align: left;">#ID</th>
            <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Cantidad</th>
            <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Descripcion</th>
            <th data-type="0" data-inner="0" scope="col" style="text-align: center;">IVA</th>
            <th data-type="1" data-inner="1" scope="col" style="text-align: center;">Talla</th>
            <th data-type="1" data-inner="1" scope="col" style="text-align: center;">Precio</th>
            <th data-type="1" data-inner="1" scope="col" style="text-align: center;">Descuento</th>
            <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Total</th>
        </tr>
    </thead>
    <tbody data-sorts="DESC">
        <?php
        $gravado = array("noGravado", "gravado");
        $tipo = array("Local", "Envio", "Apartado");
        $estado = array("inhabilitado", "habilitado");
        ?>
        <?php foreach ($productos as $producto) : ?>
            <tr class="TrRow">
                <td scope="row" style="text-align: left;"><?= $producto["idproducto"] ?></td>
                <td scope="row" style="text-align: left;"><?= $producto["cantidad"] ?></td>
                <td scope="row" style="text-align: center;"><?= $producto["descripcion"] ?></td>
                <td scope="row" data-value="<?= $producto["iva"] ?>" data-toggle="tooltip" data-placement="top" title="verde: tiene | gris: no tiene">
                    <div class="<?= $estado[$producto["iva"]] ?>"></div>
                </td>
                <td scope="row" style="text-align: center;"><?= $producto["talla"] ?></td>
                <td scope="row" style="text-align: center;">₡<?= $producto["precio"] ?></td>
                <td scope="row" data-value="<?= $producto["descuento"] ?>" data-toggle="tooltip" data-placement="top" title="verde: tiene | gris: no tiene">
                    <div class="<?= $estado[$producto["descuento"]] ?>"></div>
                </td>
                <td scope="row" style="text-align: center;">₡<?= $producto["total"] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>