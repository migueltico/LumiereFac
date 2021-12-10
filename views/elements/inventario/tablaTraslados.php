<?php
$estados = array("Pendiente", "Entregado", "Cancelado", "Devolucion")
?>
<table class="table sort" id="sortable">
    <thead>
        <tr>
            <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Id translado</th>
            <th data-type="0" data-inner="0" scope="col">Tienda de origen</th>
            <th data-type="0" data-inner="0" scope="col">Tienda para traslado</th>
            <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Comentario</th>
            <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Fecha</th>
            <th data-type="1" data-inner="1" scope="col" style="text-align: center;">Estado</th>
        </tr>
    </thead>
    <tbody id="trasladoRowsModal" data-sorts="DESC">
        <?php foreach ($traslados as $traslado) : ?>

            <?php
            $style = "";
            switch ($traslado["estado"]) {
                case 1:
                    $style = "style_pendiente";
                    break;
                case 2:
                    $style = "style_entregado";
                    break;
                case 3:
                    $style = "style_cancelado";
                    break;
                case 4:
                    $style = "style_devolucion";
                    break;

                default:
                    $style = "";
                    break;
            }  ?>
            <tr class="TrRow" id="id_traslado_<?= $traslado["uniqId"] ?>">
                <td scope="row" style="text-align: center;font-weight:bold"><?= $traslado["uniqId"] ?></td>
                <td scope="row" style="text-align: center;"><?= $traslado["tiendaOrigen"] ?></td>
                <td scope="row" style="text-align: center;"><?= $traslado["tiendaTraslado"] ?></td>
                <td scope="row" style="text-align: center;"><?= $traslado["comentario"] ?></td>
                <td scope="row" style="text-align: center;"><?= $traslado["createAt"] ?></td>
                <td scope="row" style="text-align: center;"><span class="style_buble <?=$style?>"><?= $estados[(int)$traslado["estado"] - 1] ?></span></td>
            </tr>
        <?php endforeach; ?>


    </tbody>
</table>
<style>
    .style_buble {
        border-radius: 10px;
        padding: 5px;
        box-shadow: 0px 3px 6px 0px rgba(0, 0, 0, 0.2);
    }
    .style_pendiente{
        background: yellow;
    }
    .style_entregado{
        background: green;
    }
    .style_cancelado{
        background: red;
    }
    .style_devolucion{
        background: orange;
    }
</style>