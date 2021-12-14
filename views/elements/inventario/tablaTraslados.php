<?php
$estados = array("Pendiente", "Entregado", "Cancelado", "Devolucion", "D. Aceptada")
?>


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
        case 5:
            $style = "style_devolucion_aceptada";
            break;

        default:
            $style = "";
            break;
    }
    $dbNow = strtolower($GLOBALS["DB_NAME"][$_SESSION['db']]);
    $colorTraslado = $dbNow == strtolower($traslado["dbOrigen"]) ? "salida_traslado" : "ingreso_traslado";
    $finalEstado = $estados[(int)$traslado["estado"] - 1];
    $aceptado = $dbNow == $traslado["dbTraslado"] && $traslado["estado"] == 2 ? true : false;
    $isDiffOriginDB = $dbNow != strtolower($traslado["dbOrigen"])  ? true : false;
    ?>
    <tr class="TrRow" id="id_traslado_<?= explode(".", $traslado["uniqId"])[0] ?>">
        <td scope="row" style="text-align: center;font-weight:bold;font-size:0.87rem;"><?= $traslado["uniqId"] ?></td>
        <td scope="row" style="text-align: center;font-weight:bold"><span class="style_buble <?= $colorTraslado ?>"><?= strtolower($GLOBALS["DB_NAME"][$_SESSION['db']]) == strtolower($traslado["dbOrigen"]) ? "Salida" : "Ingreso" ?></span></td>
        <td scope="row" style="text-align: center;" data-toggle="tooltip" data-placement="top" title="<?= $traslado["dbOrigen"] ?>"><?= $traslado["tiendaOrigen"] ?></td>
        <td scope="row" style="text-align: center;" data-toggle="tooltip" data-placement="top" title="<?= $traslado["dbTraslado"] ?>"><?= $traslado["tiendaTraslado"] ?></td>
        <td scope="row" style="text-align: center;"><?= $traslado["createAt"] ?></td>
        <td scope="row" style="text-align: center;"><span class="style_buble <?= $style ?>"><?= $aceptado ? "Aceptado" : $finalEstado ?></span></td>
        <td scope="row" style="text-align: center;">

            <div class="btn-group Editbuttons" aria-label="Grupo edicion">
                <!-- Ver detalles -->
                <button type="button" class="btn btn-primary seeTrasladoDetalle" data-id="<?= $traslado["uniqId"] ?>" data-toggle="modal" data-target="#traslado_detalles" data-toggle="tooltip" data-placement="bottom" title="Ver detalle"><?= $icons['eye'] ?></button>
                <!-- Check again -->
                <?php if (($isDiffOriginDB && !$aceptado)  && ($finalEstado != "Pendiente" && $finalEstado != "Entregado" && $finalEstado != "D. Aceptada")) :  ?>
                    <button type="button" class="btn btn-success pl-3 pr-3 ml-2 acceptTrasladoOrDevolution" data-dbTraslado="<?= $traslado["dbTraslado"] ?>" data-dbOrigen="<?= $traslado["dbOrigen"] ?>" data-id="<?= $traslado["uniqId"] ?>" data-toggle="tooltip" data-placement="top" title="Aceptar Traslado"><?= $icons['check'] ?></button>

                <?php endif;  ?>
                <!-- Check again for devolutions -->
                <?php if ((!$isDiffOriginDB && !$aceptado)  && ($finalEstado == "Devolucion")) :  ?>
                    <button type="button" class="btn btn-success pl-3 pr-3 ml-2 acceptTrasladoOrDevolution" data-dbTraslado="<?= $traslado["dbTraslado"] ?>" data-dbOrigen="<?= $traslado["dbOrigen"] ?>" data-id="<?= $traslado["uniqId"] ?>" data-toggle="tooltip" data-placement="top" title="Aceptar Devolucion"><?= $icons['check'] ?></button>

                <?php endif;  ?>
                <!-- Cancelar o Devolucion -->
                <?php if ($isDiffOriginDB && !$aceptado) :  ?>
                    <button type="button" class="btn btn-warning pl-3 pr-3 ml-2" data-toggle="tooltip" data-placement="top" title="Cancelar/Devolucion"><?= $icons['remove'] ?></button>
                <?php endif;  ?>

                <?php if (!$isDiffOriginDB && !$aceptado && $finalEstado == "Pendiente") :  ?>
                    <button type="button" class="btn btn-danger pl-3 pr-3 ml-2" data-toggle="tooltip" data-placement="top" title="Cancelar"><?= $icons['remove'] ?></button>
                <?php endif;  ?>
            </div>
        </td>
    </tr>
<?php endforeach; ?>



<style>
    .salida_traslado {
        background: #ff8c8c;
    }

    .ingreso_traslado {
        background: #8eff8c;
    }

    .style_buble {
        border-radius: 3px;
        padding: 5px 10px;
        box-shadow: 0px 3px 6px 0px rgba(0, 0, 0, 0.2);
        font-weight: bold;
        font-size: 0.8rem;
    }

    .style_pendiente {
        background: #ffffa4;
    }

    .style_entregado {
        background: #8eff8c;
    }

    .style_cancelado {
        background: #ff8c8c;
    }

    .style_devolucion {
        background: #ff6c6c;
    }

    .style_devolucion_aceptada {
        background: #ffc68c;
    }

    .traslado_rowColor {
        background: #ddeeff;
    }

    .table tbody tr.traslado_rowColor:hover {
        background: #ddeeff !important;
    }
</style>