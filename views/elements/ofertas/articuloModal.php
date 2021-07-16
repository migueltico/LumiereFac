<tr class="TrRow" id="row_product_oferta_<?= $data["codigo"] ?>">
    <td scope="row" style="text-align: center;"><?= $data["codigo"] ?></td>
    <td scope="row" style="text-align: center;text-transform: capitalize;"><?= $data["descripcion_short"] ?> (<?= $data["talla"] ?>)</td>
    <td scope="row" style="text-align: center;"><?= $data["marca"] ?></td>
    <td scope="row" style="text-align: center;"><?= $data["estilo"] ?></td>
    <td scope="row" style="text-align: center;"><?= $data["talla"] ?></td>
    <td scope="row" style="text-align: center;"><?= $data["precio_venta"] ?></td>

    <td scope="row">
        <div class="btn-group Editbuttons" aria-label="Grupo edicion">
            <button data-id="row_product_oferta_<?= $data["codigo"] ?>" type="button" class="btn btn-danger delete_row_oferta"><?= ($data["estado"] == 0 ? $icons['add'] : $icons['remove']) ?></button>

        </div>
    </td>
</tr>